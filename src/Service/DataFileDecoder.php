<?php

declare(strict_types=1);

namespace App\Service;

use App\Data\Data;
use App\Data\MonthData;
use App\Data\Version;
use App\Profile\BaseProfile;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\SerializerInterface;

readonly class DataFileDecoder
{
    private const string COLUMN_DATE = 'Date';

    public function __construct(
        private SerializerInterface $serializer,
    ) {}

    public function decode(BaseProfile $profile, string $filepath): Data {
        /** @var array<array<string, string|array<string, string>>> $rawData */
        $rawData = $this->getRawData(profile: $profile, filepath: $filepath);

        $data = self::getData(rawData: $rawData, profile: $profile);
        $data->setMinor();

        return $data;
    }

    /** @return array<array<string, string|array<string, string>>> */
    private function getRawData(BaseProfile $profile, string $filepath): array {
        $data = file_get_contents($filepath);
        $data = $profile->preDecodeCsvData(data: $data);

        return $this->serializer->decode($data, CsvEncoder::FORMAT, [
            CsvEncoder::ENCLOSURE_KEY => $profile->csvEnclosureKey,
            CsvEncoder::KEY_SEPARATOR_KEY => $profile->nameSeparator,
        ]);
    }

    /** @param array<array<string, string|array<string, string>>> $rawData */
    private static function getData(array $rawData, BaseProfile $profile): Data {
        $data = new Data(profile: $profile);
        foreach ($rawData as $rawMonthData) {
            $date = $rawMonthData[self::COLUMN_DATE];
            unset($rawMonthData[self::COLUMN_DATE]);

            $monthData = self::getMonthData(rawMonthData: $rawMonthData, date: $date, profile: $profile);
            $data->monthDatas[] = $monthData;
        }

        return $data;
    }

    /** @param array<string, string|array<string, string>> $rawMonthData */
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

        $monthData = new MonthData(date: \DateTime::createFromFormat('Y-m-d H:i', $date . '-15 00:00'));
        $monthData->versions = [...$versionsOther, ...self::getVersions($rawMonthData, $profile)];

        return $monthData;
    }

    /**
     * @param array<string, string|array<string, string>> $rawMonthData
     * @return array<Version>
     */
    private static function getVersions(array $rawMonthData, BaseProfile $profile): array {
        $versions = [];
        foreach ($rawMonthData as $nameWithPrefix => $percentOrMinorVersionsData) {
            $name = str_replace($profile->prefix, '', (string)$nameWithPrefix);

            if (is_string($percentOrMinorVersionsData)) {
                $percent = (float)$percentOrMinorVersionsData;
                $version = new Version(name: $name, percent: $percent);
                if ($profile->keepPrefix) {
                    $version->prefix = $profile->prefix;
                }
                $versions[] = $version;
            } else {
                $version = self::getVersionsWithMinorVersions(
                    minorVersionsData: $percentOrMinorVersionsData,
                    name: $name,
                    profile: $profile,
                );
                $versions[] = $version;
            }
        }

        return $versions;
    }

    /** @param array<string, string> $minorVersionsData */
    private static function getVersionsWithMinorVersions(
        array $minorVersionsData,
        string $name,
        BaseProfile $profile,
    ): Version {
        $version = new Version(name: $name, percent: 0);
        if ($profile->keepPrefix) {
            $version->prefix = $profile->prefix;
        }

        $majorPercent = 0;
        foreach ($minorVersionsData as $minorName => $minorPercent) {
            if ((float)$minorPercent > 0) {
                $version->minorVersions[] = new Version(
                    name: $name . $profile->nameSeparator . $minorName,
                    percent: (float)$minorPercent,
                );
                $majorPercent += (float)$minorPercent;
            }
        }

        $version->percent = $majorPercent;

        return $version;
    }
}
