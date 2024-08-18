<?php

declare(strict_types=1);

namespace App\Service;

use App\Consts;
use App\DTO\DataFileResultDTO;
use App\DTO\DataFileResultStatus;
use App\DTO\YearMonthDTO;
use App\Profile\BaseProfile;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class DataFileManager
{
    private const string DATA_FILE_DIR = Consts::DIR.'/../files/';

    private const int PREV_MONTH_DATA_AVAILABLE_FROM_DAY = 2;
    private const int CHECK_LAST_MONTHS = 12;
    private const int KEEP_LAST_FILES = 3;
    private const string FILE_LOCK_POSTFIX = '.lock';

    public function __construct(
        private HttpClientInterface $httpClient,
        private CacheInterface $cache,
        private LoggerInterface $logger,
    ) {}

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws ServerExceptionInterface
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function updateFile(BaseProfile $profile, string $subcategory): ?DataFileResultDTO {
        $result = null;
        $yearMonth = self::getLastYearMonth();

        $filePath = self::getFilePath(profile: $profile, subcategory: $subcategory, yearMonth: $yearMonth);
        if (!file_exists($filePath)) {
            self::lockFile(filePath: $filePath);
            $fileUrl = $profile->getUrl(
                subcategory: $subcategory,
                year: $yearMonth->year,
                month: $yearMonth->month,
            );

            try {
                $response = $this->httpClient->request(Request::METHOD_GET, $fileUrl);
                $content = $response->getContent();
                file_put_contents($filePath, $content);
                $message = 'Data file downloaded.';
                $this->logger->info($message, [
                    'category' => $profile->category,
                    'subcategory' => $subcategory,
                    'year' => $yearMonth->year,
                    'month' => $yearMonth->month,
                    'file_path' => $filePath,
                ]);

                self::unlockFile(filePath: $filePath);
                $cacheKey = $profile->getDataCacheKey(subcategory: $subcategory);
                $this->cache->delete($cacheKey);
                $this->logger->info('Cache for data deleted.', [
                    'category' => $profile->category,
                    'subcategory' => $subcategory,
                    'year' => $yearMonth->year,
                    'month' => $yearMonth->month,
                    'cache_key' => $cacheKey,
                ]);

                $result = new DataFileResultDTO(
                    status: DataFileResultStatus::SUCCESS,
                    filePath: $filePath,
                    message: $message,
                    fileUrl: $fileUrl,
                );
            } catch (TransportExceptionInterface $e) {
                $message = 'Data file not downloaded.';
                $this->logger->error($message, [
                    'file_path' => $filePath,
                    'error' => $e->getMessage(),
                ]);

                $result = new DataFileResultDTO(
                    status: DataFileResultStatus::FAILED,
                    filePath: $filePath,
                    message: "$message Error: {$e->getMessage()}",
                    fileUrl: $fileUrl,
                );
            } finally {
                self::unlockFile(filePath: $filePath);
            }
        }

        return $result;
    }

    /**
     * @return array<DataFileResultDTO>
     */
    public function deleteOldFiles(BaseProfile $profile, string $subcategory): array {
        $result = [];

        $yearMonth = self::getLastYearMonth();

        $filesExists = 0;
        for ($i = 0; $i < self::CHECK_LAST_MONTHS; $i++) {
            $filePath = self::getFilePath(profile: $profile, subcategory: $subcategory, yearMonth: $yearMonth);
            if (file_exists($filePath)) {
                $filesExists++;
                if ($filesExists > self::KEEP_LAST_FILES) {
                    $result[] = $this->deleteFile(filePath: $filePath);
                }
            }
            $yearMonth = self::getPreviousYearMonth(yearMonth: $yearMonth);
        }

        return $result;
    }

    private function deleteFile(string $filePath): DataFileResultDTO {
        self::lockFile(filePath: $filePath);
        $deleteResult = unlink($filePath);
        self::unlockFile(filePath: $filePath);

        if ($deleteResult) {
            $message = 'Data file deleted.';
            $this->logger->info($message, ['file_path' => $filePath]);

            return new DataFileResultDTO(
                status: DataFileResultStatus::SUCCESS,
                filePath: $filePath,
                message: $message,
            );
        }

        $message = 'Data file not deleted.';
        $this->logger->warning('Data file not deleted.', ['file_path' => $filePath]);

        return new DataFileResultDTO(
            status: DataFileResultStatus::FAILED,
            filePath: $filePath,
            message: $message,
        );
    }

    public static function getLastAvailableFilePath(BaseProfile $profile, string $subcategory): string {
        $yearMonth = self::getLastYearMonth();
        for ($i = 0; $i < self::CHECK_LAST_MONTHS; $i++) {
            $filePath = self::getFilePath(profile: $profile, subcategory: $subcategory, yearMonth: $yearMonth);
            if (file_exists($filePath) && !self::isFileLocked(filePath: $filePath)) {
                return $filePath;
            }
            $yearMonth = self::getPreviousYearMonth(yearMonth: $yearMonth);
        }

        throw new \UnexpectedValueException(
            "Not found data file for category $profile->category, subcategory $subcategory.",
        );
    }

    private static function getFilePath(BaseProfile $profile, string $subcategory, YearMonthDTO $yearMonth): string {
        $fileName = $profile->getFileName(subcategory: $subcategory, year: $yearMonth->year, month: $yearMonth->month);
        return self::DATA_FILE_DIR.$fileName;
    }

    private static function getLastYearMonth(): YearMonthDTO {
        $yearMonth = self::getPreviousYearMonth(
            yearMonth: new YearMonthDTO(year: (int)date('Y'), month: (int)date('m')),
        );
        $day = (int)date('d');
        return ($day < self::PREV_MONTH_DATA_AVAILABLE_FROM_DAY)
            ? self::getPreviousYearMonth(yearMonth: $yearMonth)
            : $yearMonth
        ;
    }

    private static function getPreviousYearMonth(YearMonthDTO $yearMonth): YearMonthDTO {
        $year = $yearMonth->year;
        $month = $yearMonth->month - 1;
        if ($month < 1) {
            $month += 12;
            $year--;
        }

        return new YearMonthDTO(year: $year, month: $month);
    }

    private static function isFileLocked(string $filePath): bool {
        return file_exists(self::getLockFilePath(filePath: $filePath));
    }

    private static function lockFile(string $filePath): void {
        file_put_contents(self::getLockFilePath(filePath: $filePath), '');
    }

    private static function unlockFile(string $filePath): void {
        $lockfilePath = self::getLockFilePath(filePath: $filePath);
        if (file_exists($lockfilePath)) {
            unlink($lockfilePath);
        }
    }

    private static function getLockFilePath(string $filePath): string {
        return $filePath.self::FILE_LOCK_POSTFIX;
    }
}
