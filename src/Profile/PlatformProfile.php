<?php

declare(strict_types=1);

namespace App\Profile;

class PlatformProfile extends BaseProfile
{
    public string $category = 'comparison';
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
    ];

    protected string $statType = 'Platform Comparison';
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_ALL => 2009,
    ];
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_ALL => 1,
    ];

    public string $sort = BaseProfile::SORT_PERCENT_ASC;

    public array $customColorsByName = [
        'Console' => '#ffd426',
        'Desktop' => '#70d7ff',
        'Mobile' => '#30db5b',
        'Tablet' => '#ff6482',
    ];

    protected function getUrlWithoutParams(string $subcategory): string {
        return ($subcategory === self::SUBCATEGORY_ALL)
            ? "$this->site/chart.php"
            : parent::getUrlWithoutParams(subcategory: $subcategory)
        ;
    }

    protected function getUrlDevicePart(string $subcategory, string $separator, bool $ucfirst = false): string {
        $devices = [];
        $platforms = [
            self::SUBCATEGORY_DESKTOP,
            self::SUBCATEGORY_MOBILE,
            self::SUBCATEGORY_TABLET,
            self::SUBCATEGORY_CONSOLE,
        ];
        foreach ($platforms as $platform) {
            $devices[] = $ucfirst ? ucfirst($platform) : $platform;
        }

        return implode($separator, $devices);
    }
}
