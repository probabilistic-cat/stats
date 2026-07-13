<?php

declare(strict_types=1);

namespace App\Profile;

use App\Helper\ColorHelper;

class OsProfile extends BaseProfile
{
    #[\Override]
    public string $category = 'os_combined';
    #[\Override]
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
        self::SUBCATEGORY_DESKTOP,
        self::SUBCATEGORY_MOBILE,
        self::SUBCATEGORY_TABLET,
        self::SUBCATEGORY_CONSOLE,
    ];

    #[\Override]
    protected string $marketShareUrlPart = 'os-market-share';
    #[\Override]
    protected string $statType = 'Operating System';
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
        'Android' => ColorHelper::SYSTEM_GREEN,
        'BlackBerry OS' => ColorHelper::SYSTEM_GRAY,
        'Chrome OS' => ColorHelper::SYSTEM_RED,
        'KaiOS' => ColorHelper::SYSTEM_INDIGO,
        'Linux' => ColorHelper::SYSTEM_YELLOW,
        'macOS' => ColorHelper::MAC_OS,
        'Nintendo' => ColorHelper::SYSTEM_RED,
        'OS X' => ColorHelper::MAC_OS,
        'Playstation' => ColorHelper::SYSTEM_INDIGO,
        'Samsung' => ColorHelper::SYSTEM_PURPLE,
        'Series 40' => ColorHelper::SYSTEM_TEAL,
        'Sony Ericsson' => ColorHelper::SYSTEM_GREEN,
        'SymbianOS' => ColorHelper::SYSTEM_ORANGE,
        'Windows' => ColorHelper::SYSTEM_BLUE,
        'Xbox' => ColorHelper::SYSTEM_GREEN,
        'iOS' => ColorHelper::SYSTEM_PINK,
        'webOS' => ColorHelper::SYSTEM_RED,
    ];
}
