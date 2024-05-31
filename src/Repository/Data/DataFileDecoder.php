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

        $versionOther = self::getVersionOther(rawMonthData: $rawMonthData);
        unset($rawMonthData[BaseProfile::VERSION_OTHER]);

        $monthData->versions = self::getVersions($rawMonthData, $profile);
        if ($versionOther instanceof Version) {
            $monthData->versions = [$versionOther, ...$monthData->versions];
        }

        return $monthData;
    }

    /**
     * @param array{string: string|array{string: string}} $rawMonthData
     */
    private static function getVersionOther(array $rawMonthData): ?Version {
        if (array_key_exists(BaseProfile::VERSION_OTHER, $rawMonthData)) {
            return new Version(
                version: BaseProfile::VERSION_OTHER,
                percent: (float)$rawMonthData[BaseProfile::VERSION_OTHER],
            );
        }

        return null;
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
