<?php

declare(strict_types=1);

namespace App\Profile;

use App\Enum\Color;

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
        'Android' => Color::SYSTEM_GREEN->value,
        'BlackBerry OS' => Color::SYSTEM_GRAY->value,
        'Chrome OS' => Color::SYSTEM_RED->value,
        'KaiOS' => Color::SYSTEM_INDIGO->value,
        'Linux' => Color::SYSTEM_YELLOW->value,
        'macOS' => Color::MAC_OS->value,
        'Nintendo' => Color::SYSTEM_RED->value,
        'OS X' => Color::MAC_OS->value,
        'Playstation' => Color::SYSTEM_INDIGO->value,
        'Samsung' => Color::SYSTEM_PURPLE->value,
        'Series 40' => Color::SYSTEM_TEAL->value,
        'Sony Ericsson' => Color::SYSTEM_GREEN->value,
        'SymbianOS' => Color::SYSTEM_ORANGE->value,
        'Windows' => Color::SYSTEM_BLUE->value,
        'Xbox' => Color::SYSTEM_GREEN->value,
        'iOS' => Color::SYSTEM_PINK->value,
        'webOS' => Color::SYSTEM_RED->value,
    ];
}
