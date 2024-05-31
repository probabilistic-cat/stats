<?php

declare(strict_types=1);

namespace App\Repository\Data;

use App\Repository\Profile\BaseProfile;
use Symfony\Component\Serializer\SerializerInterface;

class DataFileDecoder
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {}

    public function decode(BaseProfile $profile, string $filepath): Data {
        /** @var array{array{string: string|array{string: string}}} $rawData */
        $rawData = $this->getRawData(profile: $profile, filepath: $filepath);

        return self::getData(rawData: $rawData, profile: $profile);
    }

    /**
     * @return array{array{string: string|array{string: string}}}
     */
    private function getRawData(BaseProfile $profile, string $filepath): array {
        return $this->serializer->decode(
            file_get_contents($filepath),
            'csv',
            ['csv_key_separator' => $profile->versionSeparator],
        );
    }

    /**
     * @param array{array{string: string|array{string: string}}} $rawData
     */
    private static function getData(array $rawData, BaseProfile $profile): Data {
        $data = new Data(profile: $profile);
        foreach ($rawData as $rawMonthData) {
            $date = $rawMonthData[MonthData::DATE];
            unset($rawMonthData[MonthData::DATE]);

            $monthData = self::getMonthData(rawMonthData: $rawMonthData, date: $date, profile: $profile);
            $data->monthDatas[] = $monthData;
        }

        $data->setMinor();

        return $data;
    }

    /**
     * @param array{string: string|array{string: string}} $rawMonthData
     */
    private static function getMonthData(array $rawMonthData, string $date, BaseProfile $profile): MonthData {
        $monthData = new MonthData(date: $date);

        $versionsOther = self::getVersionsOther(rawMonthData: $rawMonthData);
        foreach (BaseProfile::VERSIONS_OTHER as $versionName) {
            unset($rawMonthData[$versionName]);
        }

        $monthData->versions = [...$versionsOther, ...self::getVersions($rawMonthData, $profile)];

        return $monthData;
    }

    /**
     * @param array{string: string|array{string: string}} $rawMonthData
     * @return array{Version}
     */
    private static function getVersionsOther(array $rawMonthData): array {
        $versionsOther = [];

        foreach (BaseProfile::VERSIONS_OTHER as $versionName) {
            if (array_key_exists($versionName, $rawMonthData)) {
                $versionsOther[] = new Version(
                    version: $versionName,
                    percent: (float)$rawMonthData[$versionName],
                );
            }
        }

        return $versionsOther;
    }

    /**
     * @param array{string: string|array{string: string}} $rawMonthData
     * @return array{Version}
     */
    private static function getVersions(array $rawMonthData, BaseProfile $profile): array {
        $versions = [];
        foreach ($rawMonthData as $versionNameWithPrefix => $percentOrMinorVersionsData) {
            $versionName = (string)str_replace($profile->versionPrefix, '', (string)$versionNameWithPrefix);

            if (is_string($percentOrMinorVersionsData)) {
                if ((float)$percentOrMinorVersionsData > 0) {
                    $versions[] = new Version(
                        version: $versionName,
                        percent: (float)$percentOrMinorVersionsData,
                        prefix: $profile->versionPrefix,
                    );
                }
            } else {
                $version = self::getVersionsWithMinorVersions(
                    minorVersionsData: $percentOrMinorVersionsData,
                    versionName: $versionName,
                    profile: $profile,
                );
                if ($version instanceof Version) {
                    $versions[] = $version;
                }
            }
        }

        return $versions;
    }

    /**
     * @param array{string: string} $minorVersionsData
     */
    private static function getVersionsWithMinorVersions(
        array $minorVersionsData,
        string $versionName,
        BaseProfile $profile,
    ): ?Version {
        $version = new Version(version: $versionName, percent: 0, prefix: $profile->versionPrefix);
        $majorPercent = 0;
        foreach ($minorVersionsData as $minorVersionName => $minorPercent) {
            if ((float)$minorPercent > 0) {
                $version->minorVersions[] = new Version(
                    version: $versionName.$profile->versionSeparator.$minorVersionName,
                    percent: (float)$minorPercent,
                );
                $majorPercent += (float)$minorPercent;
            }
        }

        if ($majorPercent === 0) {
            return null;
        }

        $version->percent = $majorPercent;

        return $version;
    }
}
