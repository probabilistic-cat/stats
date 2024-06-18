<?php

declare(strict_types=1);

namespace App\Profile;

class BrowserProfile extends BaseProfile
{
    public string $category = 'browser';
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
        self::SUBCATEGORY_DESKTOP,
        self::SUBCATEGORY_MOBILE,
        self::SUBCATEGORY_TABLET,
        self::SUBCATEGORY_CONSOLE,
    ];

    protected string $marketShareUrlPart = 'browser-market-share';
    protected string $statType = 'Browser';
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
    protected bool $isUrlPathShort = true;

    public string $sort = BaseProfile::SORT_PERCENT_ASC;

    public array $customColorsByName = [
        '360 Safe Browser' => '#30db5b',
        'Android' => '#7d7aff',
        'BlackBerry' => '#aeaeb2',
        'Bolt' => '#70d7ff',
        'Chrome' => '#30db5b',
        'Coc Coc' => '#a2d34b',
        'Dolfin' => '#30db5b',
        'Edge Legacy' => '#5fa3e6',
        'Edge' => '#70d7ff',
        'Firefox' => '#ffb33f',
        'IE' => '#67d4cf',
        'IEMobile' => '#3f7aff',
        'Instabridge' => '#f7aa6e',
        'Jasmine' => '#c28dbc',
        'Mozilla' => '#ffb33f',
        'NetFront NX' => '#acdc5a',
        'NetFront' => '#acdc5a',
        'Nokia' => '#2fbacd',
        'Obigo' => '#70d7ff',
        'Openwave' => '#ba94c8',
        'Opera' => '#ff6861',
        'QQ Browser' => '#70d7ff',
        'Safari' => '#d8d8dc',
        'Samsung Internet' => '#da8fff',
        'Samsung' => '#da8fff',
        'Silk' => '#ffb33f',
        'Sony PS3' => '#7d7aff',
        'Sony PS4' => '#ff6482',
        'Sony PSP Vita' => '#70d7ff',
        'SonyEricsson' => '#30db5b',
        'UC Browser' => '#ffd426',
        'Whale Browser' => '#01d3ae',
        'Yandex Browser' => '#ffd426',
    ];
}
