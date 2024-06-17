<?php

declare(strict_types=1);

namespace App\Profile;

use App\Consts;

abstract class BaseProfile
{
    protected const string SUBCATEGORY_ALL = 'all';

    public const string COLOR_OTHER = '#d8d8dc';
    public const array NAMES_OTHER = ['Unknown', 'Other'];
    public const string PREFIX_OTHER = '';

    public const string SORT_PERCENT_ASC = 'sort_percent_asc';
    public const string SORT_NAME_ASC = 'sort_name_asc';

    protected const string DUMMY_YEAR = 'YYYY';
    protected const string DUMMY_MONTH = 'MM';

    public string $category;
    /** @var array<string> */
    public array $subcategories;

    protected string $site = 'https://gs.statcounter.com';
    protected string $region = 'worldwide';
    protected string $regionHidden = 'ww';
    protected string $granularity = 'monthly';
    protected string $marketShareUrlPart;
    protected string $statType;
    /** @var array<string, int> */
    protected array $fromYearBySubcategory;
    /** @var array<string, int> */
    protected array $fromMonthBySubcategory;

    /** @var array<string, string> */
    protected array $fileNames;

    public string $prefix = '';
    public string $nameSeparator = '~';

    /** @var array<string> */
    public array $colors = [
        '#70d7ff', '#ffb33f', '#da8fff', '#30db5b', '#ffd426', '#ff6482', '#67d4cf', '#7d7aff', '#ff6861',
    ];
    /** @var array<string, string> */
    public array $customColorsByName = [];

    public string $sort = self::SORT_NAME_ASC;

    public function getFilePath(string $subcategory, int $year, int $month): string {
        if (!in_array($subcategory, $this->subcategories, true)) {
            throw new \InvalidArgumentException("Unknown subcategory: $subcategory");
        }

        $filePath = Consts::DIR.'/File/'.$this->fileNames[$subcategory];

        return str_replace(
            [self::DUMMY_YEAR, self::DUMMY_MONTH],
            [(string)$year, mb_str_pad((string)$month, 2, '0', STR_PAD_LEFT)],
            $filePath,
        );
    }

    public function getUrl(string $subcategory, int $year, int $month): string {
        if (!in_array($subcategory, $this->subcategories, true)) {
            throw new \InvalidArgumentException("Unknown subcategory: $subcategory");
        }

        $multiDevicePart = ($subcategory === self::SUBCATEGORY_ALL) ? '&multi-device=true' : '';

        $url = $this->getUrlWithoutParams(subcategory: $subcategory);
        $url .= '?device='
            .rawurlencode($this->getUrlDevicePart(subcategory: $subcategory, separator: ' & ', ucfirst: true))
        ;
        $url .= '&device_hidden='.rawurlencode($this->getUrlDevicePart(subcategory: $subcategory, separator: '+'));
        $url .= $multiDevicePart;
        $url .= '&statType_hidden='.$this->category;
        $url .= '&region_hidden='.$this->regionHidden;
        $url .= '&granularity='.$this->granularity;
        $url .= '&statType='.rawurlencode($this->statType);
        $url .= '&region='.ucfirst($this->region);
        $url .= '&fromInt='.$this->fromYearBySubcategory[$subcategory]
            .mb_str_pad((string)$this->fromMonthBySubcategory[$subcategory], 2, '0', STR_PAD_LEFT)
        ;
        $url .= '&toInt='.$year.mb_str_pad((string)$month, 2, '0', STR_PAD_LEFT);
        $url .= '&fromMonthYear='.$this->fromYearBySubcategory[$subcategory].'-'
            .mb_str_pad((string)$this->fromMonthBySubcategory[$subcategory], 2, '0', STR_PAD_LEFT)
        ;
        $url .= '&toMonthYear='.$year.'-'.mb_str_pad((string)$month, 2, '0', STR_PAD_LEFT);
        $url .= '&csv=1';

        return $url;
    }

    protected function getUrlWithoutParams(string $subcategory): string {
        $devicePart = $this->getUrlDevicePart(subcategory: $subcategory, separator: '-');
        return "$this->site/$this->marketShareUrlPart/$devicePart/$this->region/chart.php";
    }

    private function getUrlDevicePart(string $subcategory, string $separator, bool $ucfirst = false): string {
        if ($subcategory === self::SUBCATEGORY_ALL) {
            $devices = [];
            foreach ($this->subcategories as $device) {
                if ($device !== self::SUBCATEGORY_ALL) {
                    $devices[] = $ucfirst ? ucfirst($device) : $device;
                }
            }

            return implode($separator, $devices);
        }

        return $ucfirst ? ucfirst($subcategory) : $subcategory;
    }

    public function getDataCacheKey(string $subcategory): string {
        return 'data_'.$this->category.'_'.$subcategory;
    }

    /**
     * @return array<string, string>
     */
    protected static function getCustomColorsByNumberName(): array {
        $customColors0to10 = [
            0 => '#aeaeb2',
            1 => '#ff6861',
            2 => '#ffb33f',
            3 => '#70d7ff',
            4 => '#30db5b',
            5 => '#da8fff',
            6 => '#ffd426',
            7 => '#ff6482',
            8 => '#67d4cf',
            9 => '#7d7aff',
        ];

        $customColors = [];
        $tens = 3;
        for ($indexTens = 0; $indexTens < $tens; $indexTens++) {
            foreach ($customColors0to10 as $index0to10 => $color) {
                $index = $indexTens * 10 + $index0to10;
                $customColors[(string)$index] = $color;
            }
        }

        return $customColors;
    }
}
