<?php

declare(strict_types=1);

namespace App\Profile;

class OsProfile extends BaseProfile
{
    public const string SUBCATEGORY_ALL = 'all';
    public const string SUBCATEGORY_DESKTOP = 'desktop';
    public const string SUBCATEGORY_MOBILE = 'mobile';
    public const string SUBCATEGORY_TABLET = 'tablet';
    public const string SUBCATEGORY_CONSOLE = 'console';

    public string $category = 'os_combined';
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
        self::SUBCATEGORY_DESKTOP,
        self::SUBCATEGORY_MOBILE,
        self::SUBCATEGORY_TABLET,
        self::SUBCATEGORY_CONSOLE,
    ];

    protected string $marketShareUrlPart = 'os-market-share';
    protected string $statType = 'Operating System';
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_ALL => 2009,
        self::SUBCATEGORY_DESKTOP => 2009,
        self::SUBCATEGORY_MOBILE => 2009,
        self::SUBCATEGORY_TABLET => 2012,
        self::SUBCATEGORY_CONSOLE => 2012,
    ];
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_ALL => 1,
        self::SUBCATEGORY_DESKTOP => 1,
        self::SUBCATEGORY_MOBILE => 1,
        self::SUBCATEGORY_TABLET => 8,
        self::SUBCATEGORY_CONSOLE => 8,
    ];

    public string $sort = BaseProfile::SORT_PERCENT_ASC;

    public array $customColorsByName = [
        'Android' => '#30db5b',
        'BlackBerry OS' => '#aeaeb2',
        'Chrome OS' => '#ff6861',
        'KaiOS' => '#7d7aff',
        'Linux' => '#ffd426',
        'Nintendo' => '#ff6861',
        'OS X' => '#2dd4bf',
        'Playstation' => '#7d7aff',
        'Samsung' => '#da8fff',
        'Series 40' => '#2fbacd',
        'Sony Ericsson' => '#30db5b',
        'SymbianOS' => '#ffb33f',
        'Windows' => '#70d7ff',
        'Xbox' => '#30db5b',
        'iOS' => '#ff6482',
        'webOS' => '#ff6861',
    ];

    protected function getUrlWithoutParams(string $subcategory): string {
        return ($subcategory === self::SUBCATEGORY_ALL)
            ? "$this->site/chart.php"
            : parent::getUrlWithoutParams(subcategory: $subcategory)
        ;
    }
}
