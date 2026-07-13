<?php

declare(strict_types=1);

namespace App\Profile;

use App\Enum\Color;

class BrowserProfile extends BaseProfile
{
    #[\Override]
    public string $category = 'browser';
    #[\Override]
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
        self::SUBCATEGORY_DESKTOP,
        self::SUBCATEGORY_MOBILE,
        self::SUBCATEGORY_TABLET,
        self::SUBCATEGORY_CONSOLE,
    ];

    #[\Override]
    protected string $marketShareUrlPart = 'browser-market-share';
    #[\Override]
    protected string $statType = 'Browser';
    #[\Override]
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_ALL => 2009,
        self::SUBCATEGORY_DESKTOP => 2009,
        self::SUBCATEGORY_MOBILE => 2009,
        self::SUBCATEGORY_TABLET => 2012,
        self::SUBCATEGORY_CONSOLE => 2012,
    ];
    #[\Override]
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_ALL => 1,
        self::SUBCATEGORY_DESKTOP => 1,
        self::SUBCATEGORY_MOBILE => 1,
        self::SUBCATEGORY_TABLET => 8,
        self::SUBCATEGORY_CONSOLE => 8,
    ];
    #[\Override]
    protected bool $isUrlPathShort = true;

    #[\Override]
    public array $customColorsByName = [
        '360 Safe Browser' => Color::SYSTEM_GREEN->value,
        'Android' => Color::SYSTEM_INDIGO->value,
        'BlackBerry' => Color::SYSTEM_GRAY->value,
        'Bolt' => Color::SYSTEM_BLUE->value,
        'Chrome' => Color::SYSTEM_GREEN->value,
        'Coc Coc' => '#a2d34b',
        'Dolfin' => Color::SYSTEM_GREEN->value,
        'Edge Legacy' => '#5fa3e6',
        'Edge' => Color::SYSTEM_BLUE->value,
        'Firefox' => Color::SYSTEM_ORANGE->value,
        'IE' => Color::SYSTEM_MINT->value,
        'IEMobile' => '#3f7aff',
        'Instabridge' => '#f7aa6e',
        'Jasmine' => '#c28dbc',
        'Mozilla' => Color::SYSTEM_ORANGE->value,
        'NetFront NX' => '#acdc5a',
        'NetFront' => '#acdc5a',
        'Nokia' => Color::SYSTEM_TEAL->value,
        'Obigo' => Color::SYSTEM_BLUE->value,
        'Openwave' => '#ba94c8',
        'Opera' => Color::SYSTEM_RED->value,
        'QQ Browser' => Color::SYSTEM_BLUE->value,
        'Safari' => Color::SYSTEM_GRAY->value,
        'Samsung Internet' => Color::SYSTEM_PURPLE->value,
        'Samsung' => Color::SYSTEM_PURPLE->value,
        'Silk' => Color::SYSTEM_ORANGE->value,
        'Sony PS3' => Color::SYSTEM_INDIGO->value,
        'Sony PS4' => Color::SYSTEM_PINK->value,
        'Sony PSP Vita' => Color::SYSTEM_BLUE->value,
        'SonyEricsson' => Color::SYSTEM_GREEN->value,
        'UC Browser' => Color::SYSTEM_YELLOW->value,
        'Whale Browser' => '#01d3ae',
        'Yandex Browser' => Color::SYSTEM_YELLOW->value,
    ];
}
