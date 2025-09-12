<?php

declare(strict_types=1);

namespace App\Profile;

use App\Helper\ColorHelper;

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

    public array $customColorsByName = [
        '360 Safe Browser' => ColorHelper::SYSTEM_GREEN,
        'Android' => ColorHelper::SYSTEM_INDIGO,
        'BlackBerry' => ColorHelper::SYSTEM_GRAY,
        'Bolt' => ColorHelper::SYSTEM_BLUE,
        'Chrome' => ColorHelper::SYSTEM_GREEN,
        'Coc Coc' => '#a2d34b',
        'Dolfin' => ColorHelper::SYSTEM_GREEN,
        'Edge Legacy' => '#5fa3e6',
        'Edge' => ColorHelper::SYSTEM_BLUE,
        'Firefox' => ColorHelper::SYSTEM_ORANGE,
        'IE' => ColorHelper::WINDOWS_98,
        'IEMobile' => '#3f7aff',
        'Instabridge' => '#f7aa6e',
        'Jasmine' => '#c28dbc',
        'Mozilla' => ColorHelper::SYSTEM_ORANGE,
        'NetFront NX' => '#acdc5a',
        'NetFront' => '#acdc5a',
        'Nokia' => ColorHelper::SYSTEM_TEAL,
        'Obigo' => ColorHelper::SYSTEM_BLUE,
        'Openwave' => '#ba94c8',
        'Opera' => ColorHelper::SYSTEM_RED,
        'QQ Browser' => ColorHelper::SYSTEM_BLUE,
        'Safari' => ColorHelper::SYSTEM_GRAY,
        'Samsung Internet' => ColorHelper::SYSTEM_PURPLE,
        'Samsung' => ColorHelper::SYSTEM_PURPLE,
        'Silk' => ColorHelper::SYSTEM_ORANGE,
        'Sony PS3' => ColorHelper::SYSTEM_INDIGO,
        'Sony PS4' => ColorHelper::SYSTEM_PINK,
        'Sony PSP Vita' => ColorHelper::SYSTEM_BLUE,
        'SonyEricsson' => ColorHelper::SYSTEM_GREEN,
        'UC Browser' => ColorHelper::SYSTEM_YELLOW,
        'Whale Browser' => '#01d3ae',
        'Yandex Browser' => ColorHelper::SYSTEM_YELLOW,
    ];
}
