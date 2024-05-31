<?php

declare(strict_types=1);

namespace App\Repository\Profile;

class BrowserProfile extends BaseProfile
{
    public const string SUBCATEGORY_ALL = 'All';
    public const string SUBCATEGORY_DESKTOP = 'Desktop';
    public const string SUBCATEGORY_MOBILE = 'Mobile';
    public const string SUBCATEGORY_TABLET = 'Tablet';
    public const string SUBCATEGORY_CONSOLE = 'Console';

    public string $category = 'Browsers';
    public array $subcategoriesLinks = [
        self::SUBCATEGORY_ALL => 'app_browser_all',
        self::SUBCATEGORY_DESKTOP => 'app_browser_desktop',
        self::SUBCATEGORY_MOBILE => 'app_browser_mobile',
        self::SUBCATEGORY_TABLET => 'app_browser_tablet',
        self::SUBCATEGORY_CONSOLE => 'app_browser_console',
    ];

    protected array $filenames = [
        self::SUBCATEGORY_ALL => 'browser-ww-monthly-200901-202404.csv',
        self::SUBCATEGORY_DESKTOP => 'browser_desktop-ww-monthly-200901-202404.csv',
        self::SUBCATEGORY_MOBILE => 'browser_mobile-ww-monthly-200901-202404.csv',
        self::SUBCATEGORY_TABLET => 'browser_tablet-ww-monthly-201208-202404.csv',
        self::SUBCATEGORY_CONSOLE => 'browser_console-ww-monthly-201208-202404.csv',
    ];

    public string $sort = BaseProfile::SORT_PERCENT_ASC;

    public array $customColorsByVersion = [
        '360 Safe Browser' => '#30db5b',
        'Android' => '#7d7aff',
        'BlackBerry' => '#afafaf',
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
        'Sony PSP' => '#70d7ff',
        'SonyEricsson' => '#30db5b',
        'UC Browser' => '#ffd426',
        'Whale Browser' => '#01d3ae',
        'Yandex Browser' => '#ffd426',
    ];
}
