<?php

declare(strict_types=1);

namespace App\Service;

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
    private const int PREV_MONTH_DATA_AVAILABLE_FROM_DAY = 2;
    private const int CHECK_LAST_MONTHS = 12;
    private const int KEEP_FILES_LAST_MONTHS = 3;
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

        $filePath = $profile->getFilePath(subcategory: $subcategory, year: $yearMonth->year, month: $yearMonth->month);
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
                    status: DataFileResultDTO::STATUS_SUCCESS,
                    filePath: $filePath,
                    message: $message,
                );
                $result->fileUrl = $fileUrl;
            } catch (TransportExceptionInterface $e) {
                $message = 'Data file not downloaded.';
                $this->logger->error($message, [
                    'file_path' => $filePath,
                    'error' => $e->getMessage(),
                ]);

                $result = new DataFileResultDTO(
                    status: DataFileResultDTO::STATUS_FAILURE,
                    filePath: $filePath,
                    message: "$message Error: {$e->getMessage()}",
                );
                $result->fileUrl = $fileUrl;
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

        $yearMonth = self::getPreviousYearMonth(
            yearMonth: self::getLastYearMonth(),
            monthsAgo: self::KEEP_FILES_LAST_MONTHS,
        );

        for ($i = self::KEEP_FILES_LAST_MONTHS; $i < self::CHECK_LAST_MONTHS; $i++) {
            $filePath = $profile->getFilePath(
                subcategory: $subcategory,
                year: $yearMonth->year,
                month: $yearMonth->month,
            );
            if (file_exists($filePath)) {
                self::lockFile(filePath: $filePath);
                $deleteResult = unlink($filePath);
                if ($deleteResult) {
                    $message = 'Data file deleted.';
                    $this->logger->info($message, ['file_path' => $filePath]);

                    $result[] = new DataFileResultDTO(
                        status: DataFileResultDTO::STATUS_SUCCESS,
                        filePath: $filePath,
                        message: $message,
                    );
                } else {
                    $message = 'Data file not deleted.';
                    $this->logger->warning('Data file not deleted.', ['file_path' => $filePath]);

                    $result[] = new DataFileResultDTO(
                        status: DataFileResultDTO::STATUS_FAILURE,
                        filePath: $filePath,
                        message: $message,
                    );
                }
                self::unlockFile(filePath: $filePath);
            }
            $yearMonth = self::getPreviousYearMonth(yearMonth: $yearMonth);
        }

        return $result;
    }

    public static function getLastAvailableFilePath(BaseProfile $profile, string $subcategory): string {
        $yearMonth = self::getLastYearMonth();
        for ($i = 0; $i < self::CHECK_LAST_MONTHS; $i++) {
            $filePath = $profile->getFilePath(
                subcategory: $subcategory,
                year: $yearMonth->year,
                month: $yearMonth->month,
            );
            if (file_exists($filePath) && !self::isFileLocked(filePath: $filePath)) {
                return $filePath;
            }
            $yearMonth = self::getPreviousYearMonth(yearMonth: $yearMonth);
        }

        throw new \UnexpectedValueException(
            "Not found data file for category $profile->category, subcategory $subcategory.",
        );
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

    private static function getPreviousYearMonth(YearMonthDTO $yearMonth, int $monthsAgo = 1): YearMonthDTO {
        $year = $yearMonth->year;
        $month = $yearMonth->month - $monthsAgo;
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

class YearMonthDTO
{
    public function __construct(
        public int $year,
        public int $month,
    ) {}
}

class DataFileResultDTO
{
    public const string STATUS_SUCCESS = 'success';
    public const string STATUS_FAILURE = 'failure';

    public ?string $fileUrl = null;

    public function __construct(
        public string $status,
        public string $filePath,
        public string $message,
    ) {}
}
