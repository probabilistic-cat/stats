<?php

declare(strict_types=1);

namespace App\Data\Decoder;

use Symfony\Component\Serializer\SerializerInterface;

class DataFileDecoder
{
    private const string FILE_PATH = __DIR__.'/../File/';

    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {}

    public function decode(string $filename, string $versionSeparator, string $versionPrefix = ''): DataDTO {
        /** @var array{array{string: string|array{string: string}}} $rawData */
        $rawData = $this->getRawData($filename, $versionSeparator);

        return self::getData(rawData: $rawData, versionPrefix: $versionPrefix);
    }

    /**
     * @return array{array{string: string|array{string: string}}}
     */
    private function getRawData(string $filename, string $versionSeparator): array {
        return $this->serializer->decode(
            file_get_contents(self::FILE_PATH.$filename),
            'csv',
            ['csv_key_separator' => $versionSeparator],
        );
    }

    /**
     * @param array{array{string: string|array{string: string}}} $rawData
     */
    private static function getData(array $rawData, string $versionPrefix): DataDTO {
        $data = new DataDTO(false);
        foreach ($rawData as $rawMonthData) {
            $date = $rawMonthData[MonthDataDTO::DATE];
            unset($rawMonthData[MonthDataDTO::DATE]);

            $monthData = self::getMonthData(rawMonthData: $rawMonthData, date: $date, versionPrefix: $versionPrefix);
            $data->monthDatas[] = $monthData;
        }
        usort($data->monthDatas, static fn (MonthDataDTO $a, MonthDataDTO $b): int => $b->date <=> $a->date);
        $data->setMinor();

        return $data;
    }

    /**
     * @param array{string: string|array{string: string}} $rawMonthData
     */
    private static function getMonthData(array $rawMonthData, string $date, string $versionPrefix): MonthDataDTO {
        $monthData = new MonthDataDTO(date: $date);
        foreach ($rawMonthData as $versionName => $percentOrMinorVersionsData) {
            if ($versionName !== VersionDTO::VERSION_OTHER) {
                $versionName = (string)str_replace($versionPrefix, '', $versionName);
            }

            $monthData->versions[] = is_string($percentOrMinorVersionsData)
                ? self::getVersion(
                    versionName: $versionName,
                    versionPrefix: $versionPrefix,
                    percent: (float)$percentOrMinorVersionsData,
                )
                : self::getVersionWithMinorVersions(
                    minorVersionsData: $percentOrMinorVersionsData,
                    versionName: $versionName,
                    versionPrefix: $versionPrefix,
                )
            ;
        }

        // version 'Other' comes first
        usort($monthData->versions, static function (VersionDTO $a, VersionDTO $b): int {
            if ($a->version === VersionDTO::VERSION_OTHER && $a->version !== $b->version) {
                return -1;
            }

            if ($b->version === VersionDTO::VERSION_OTHER && $a->version !== $b->version) {
                return 1;
            }

            return $a->version <=> $b->version;
        });

        return $monthData;
    }

    private static function getVersion(string $versionName, string $versionPrefix, float $percent): VersionDTO {
        $version = new VersionDTO(version: $versionName, percent: $percent);
        $version->prefix = ($versionName === VersionDTO::VERSION_OTHER)
            ? VersionDTO::PREFIX_OTHER
            : $versionPrefix
        ;

        return $version;
    }

    /**
     * @param array{string: string} $minorVersionsData
     */
    private static function getVersionWithMinorVersions(
        array $minorVersionsData,
        string $versionName,
        string $versionPrefix,
    ): VersionDTO {
        $version = new VersionDTO(version: $versionName, percent: 0, prefix: $versionPrefix);
        $majorPercent = 0;
        foreach ($minorVersionsData as $minorVersionStr => $minorPercent) {
            $version->minorVersions[] = new VersionDTO(
                version: (string)$minorVersionStr,
                percent: (float)$minorPercent,
            );
            $majorPercent += (float)$minorPercent;
        }
        $version->percent = $majorPercent;

        usort(
            $version->minorVersions,
            static fn (VersionDTO $a, VersionDTO $b): int => $a->version <=> $b->version,
        );

        return $version;
    }
}
