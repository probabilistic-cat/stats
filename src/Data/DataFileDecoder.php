<?php

declare(strict_types=1);

namespace App\Data;

use Symfony\Component\Serializer\SerializerInterface;

class DataFileDecoder
{
    private const string FILE_PATH = __DIR__.'/../Data/File/';

    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {}

    /**
     * @return MonthDataDTO[]
     */
    public function decode(string $filename, string $versionSeparator, string $versionPrefix = ''): array {
        /** @var array{array{string: string|array{string: string}}} $rawData */
        $rawData = $this->getRawData($filename, $versionSeparator);

        $data = [];
        foreach ($rawData as $rawMonthData) {
            $date = $rawMonthData[MonthDataDTO::DATE];
            $versionOther = new VersionDTO(
                version: VersionDTO::VERSION_OTHER,
                percent: array_key_exists(VersionDTO::VERSION_OTHER, $rawMonthData)
                    ? (float)$rawMonthData[VersionDTO::VERSION_OTHER]
                    : 0,
                prefix: $versionPrefix,
            );
            unset($rawMonthData[MonthDataDTO::DATE], $rawMonthData[VersionDTO::VERSION_OTHER]);

            $versions = [];
            foreach ($rawMonthData as $versionStr => $percentOrMinorVersionsData) {
                $versionStr = (string)str_replace($versionPrefix, '', $versionStr);

                if (is_string($percentOrMinorVersionsData)) {
                    $percent = (float)$percentOrMinorVersionsData;
                    $versions[] = new VersionDTO(version: $versionStr, percent: $percent, prefix: $versionPrefix);
                    continue;
                }

                $minorVersions = [];
                $majorPercent = 0;
                foreach ((array)$percentOrMinorVersionsData as $minorVersionStr => $percent) {
                    $minorVersions[] = new VersionDTO(version: (string)$minorVersionStr, percent: (float)$percent);
                    $majorPercent += (float)$percent;
                }
                usort($minorVersions, static fn (VersionDTO $a, VersionDTO $b): int => $a->version <=> $b->version);

                $versions[] = new VersionDTO(
                    version: $versionStr,
                    percent: $majorPercent,
                    prefix: $versionPrefix,
                    minorVersions: $minorVersions,
                );
            }

            usort($versions, static fn (VersionDTO $a, VersionDTO $b): int => $a->version <=> $b->version);
            array_unshift($versions, $versionOther);

            $data[] = new MonthDataDTO(date: $date, versions: $versions);
        }
        usort($data, static fn (MonthDataDTO $a, MonthDataDTO $b): int => $b->date <=> $a->date);

        return $data;
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
}
