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
            ['csv_key_separator' => $profile->nameSeparator],
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
        $versionsOther = [];
        foreach (BaseProfile::NAMES_OTHER as $name) {
            if (array_key_exists($name, $rawMonthData)) {
                $versionsOther[] = new Version(
                    name: $name,
                    percent: (float)$rawMonthData[$name],
                );
                unset($rawMonthData[$name]);
            }
        }

        $monthData = new MonthData(date: $date);
        $monthData->versions = [...$versionsOther, ...self::getVersions($rawMonthData, $profile)];

        return $monthData;
    }

    /**
     * @param array{string: string|array{string: string}} $rawMonthData
     * @return array{Version}
     */
    private static function getVersions(array $rawMonthData, BaseProfile $profile): array {
        $versions = [];
        foreach ($rawMonthData as $nameWithPrefix => $percentOrMinorVersionsData) {
            $name = (string)str_replace($profile->prefix, '', (string)$nameWithPrefix);

            if (is_string($percentOrMinorVersionsData)) {
                $percent = (float)$percentOrMinorVersionsData;
                if ($percent > 0) {
                    $versions[] = new Version(
                        name: $name,
                        percent: $percent,
                        prefix: $profile->prefix,
                    );
                }
            } else {
                $version = self::getVersionsWithMinorVersions(
                    minorVersionsData: $percentOrMinorVersionsData,
                    name: $name,
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
        string $name,
        BaseProfile $profile,
    ): ?Version {
        $version = new Version(name: $name, percent: 0, prefix: $profile->prefix);
        $majorPercent = 0;
        foreach ($minorVersionsData as $minorName => $minorPercent) {
            if ((float)$minorPercent > 0) {
                $version->minorVersions[] = new Version(
                    name: $name.$profile->nameSeparator.$minorName,
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
