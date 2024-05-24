<?php

namespace App\Data;

use Symfony\Component\Serializer\SerializerInterface;

class DataFileDecoder
{
    private const string FILE_PATH = __DIR__ . '/../Data/File/';

    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {}

    /**
     * @return MonthDataDTO[]
     */
    public function decode(string $filename, string $versionPrefix = ''): array {
        $rawData = $this->getRawData($filename);

        $result = [];
        foreach ($rawData as $rawMonthData) {
            $date = $rawMonthData[MonthDataDTO::DATE];
            $versionOther = new VersionDTO(
                version: VersionDTO::VERSION_OTHER,
                prefix: $versionPrefix,
                percent: array_key_exists(VersionDTO::VERSION_OTHER, $rawMonthData)
                    ? $rawMonthData[VersionDTO::VERSION_OTHER]
                    : 0,
            );
            unset($rawMonthData[MonthDataDTO::DATE], $rawMonthData[VersionDTO::VERSION_OTHER]);

            $versionsData = [];
            foreach ($rawMonthData as $fullVersion => $percent) {
                $fullVersion = mb_substr($fullVersion, mb_strrpos($fullVersion, ' ') + 1);
                $versionStr = mb_substr($fullVersion, 0, mb_strrpos($fullVersion, '.'));
//                $minorVersion = mb_substr($fullVersion, mb_strrpos($fullVersion, '.') + 1);
                $percent = (float)$percent;

                if (!array_key_exists($versionStr, $versionsData)) {
                    $versionsData[$versionStr] = 0;
                }
                $versionsData[$versionStr] += $percent;
            }

            $versions = [];
            foreach ($versionsData as $versionStr => $percent) {
                $versions[] = new VersionDTO(version: $versionStr, prefix: $versionPrefix, percent: $percent);
            }
            usort($versions, static fn (VersionDTO $a, VersionDTO $b) => $a->version <=> $b->version);
            array_unshift($versions, $versionOther);

            $result[] = new MonthDataDTO(date: $date, versions: $versions);
        }
        usort($result, static fn (MonthDataDTO $a, MonthDataDTO $b) => $b->date <=> $a->date);

        return $result;
    }

    private function getRawData(string $filename): array {
        return $this->serializer->decode(
            file_get_contents(self::FILE_PATH.$filename),
            'csv',
            ['csv_key_separator' => '^'], // disable grouping
        );
    }
}