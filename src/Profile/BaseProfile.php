<?php

declare(strict_types=1);

namespace App\Profile;

use App\Enum\ProfileSort;
use App\Helper\ColorHelper;

abstract class BaseProfile
{
    public const string SUBCATEGORY_ALL = 'all';
    public const string SUBCATEGORY_DESKTOP = 'desktop';
    public const string SUBCATEGORY_MOBILE = 'mobile';
    public const string SUBCATEGORY_TABLET = 'tablet';
    public const string SUBCATEGORY_CONSOLE = 'console';

    public const array NAMES_OTHER = ['Unknown', 'Other'];
    public const string PREFIX_OTHER = '';

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
    protected bool $isUrlPathShort = false;

    public string $prefix = '';
    public bool $keepPrefix = false;

    public string $nameSeparator = '~';

    /** @var array<string> */
    public array $colors = [
        ColorHelper::SYSTEM_BLUE,
        ColorHelper::SYSTEM_ORANGE,
        ColorHelper::SYSTEM_PURPLE,
        ColorHelper::SYSTEM_GREEN,
        ColorHelper::SYSTEM_YELLOW,
        ColorHelper::SYSTEM_PINK,
        ColorHelper::SYSTEM_MINT,
        ColorHelper::SYSTEM_INDIGO,
        ColorHelper::SYSTEM_RED,
    ];
    /** @var array<string, string> */
    public array $customColorsByName = [];

    public ProfileSort $sort = ProfileSort::PERCENT_ASC;
    /** @var array<int, string> */
    public array $customSortedNames;

    public function getFileName(string $subcategory, int $year, int $month): string {
        $this->checkSubcategory(subcategory: $subcategory);

        return "{$this->category}_{$subcategory}-{$this->regionHidden}-{$this->granularity}-"
            .$this->fromYearBySubcategory[$subcategory]
            .mb_str_pad((string)$this->fromMonthBySubcategory[$subcategory], 2, '0', STR_PAD_LEFT)
            .'-'.$year.mb_str_pad((string)$month, 2, '0', STR_PAD_LEFT)
            .'.csv'
        ;
    }

    public function getUrl(string $subcategory, int $year, int $month): string {
        $this->checkSubcategory(subcategory: $subcategory);

        $multiDevicePart = ($subcategory === self::SUBCATEGORY_ALL) ? '&multi-device=true' : '';

        $url = $this->getUrlPath(subcategory: $subcategory);
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

    public function getSourceUrl(string $subcategory): string {
        $devicePart = $this->getUrlDevicePart(subcategory: $subcategory, separator: '-');
        return "{$this->site}/$this->marketShareUrlPart/$devicePart/$this->region/";
    }

    protected function getUrlPath(string $subcategory): string {
        $devicePart = $this->getUrlDevicePart(subcategory: $subcategory, separator: '-');
        $longPathPart = ($this->isUrlPathShort && $subcategory === self::SUBCATEGORY_ALL)
            ? ''
            : "$this->marketShareUrlPart/$devicePart/$this->region/"
        ;
        return "{$this->site}/{$longPathPart}chart.php";
    }

    protected function getUrlDevicePart(string $subcategory, string $separator, bool $ucfirst = false): string {
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
            0 => ColorHelper::SYSTEM_GRAY,
            1 => ColorHelper::SYSTEM_RED,
            2 => ColorHelper::SYSTEM_ORANGE,
            3 => ColorHelper::SYSTEM_BLUE,
            4 => ColorHelper::SYSTEM_GREEN,
            5 => ColorHelper::SYSTEM_PURPLE,
            6 => ColorHelper::SYSTEM_YELLOW,
            7 => ColorHelper::SYSTEM_PINK,
            8 => ColorHelper::SYSTEM_MINT,
            9 => ColorHelper::SYSTEM_INDIGO,
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

    private function checkSubcategory(string $subcategory): void {
        if (!in_array($subcategory, $this->subcategories, true)) {
            throw new \InvalidArgumentException("Unknown subcategory: $subcategory");
        }
    }
}
