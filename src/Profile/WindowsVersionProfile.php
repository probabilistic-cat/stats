<?php

declare(strict_types=1);

namespace App\Profile;

use App\Enum\ProfileSort;
use App\Helper\ColorHelper;

class WindowsVersionProfile extends BaseProfile
{
    #[\Override]
    public string $category = 'windows_version';
    #[\Override]
    public array $subcategories = [
        self::SUBCATEGORY_DESKTOP,
    ];

    #[\Override]
    protected string $marketShareUrlPart = 'windows-version-market-share';
    #[\Override]
    protected string $statType = 'Windows Version';
    #[\Override]
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_DESKTOP => 2009,
    ];
    #[\Override]
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_DESKTOP => 1,
    ];

    #[\Override]
    public string $prefix = 'Win';

    #[\Override]
    public ProfileSort $sort = ProfileSort::Custom;
    #[\Override]
    public array $customSortedNames = [
        '98',
        'ME',
        '2000',
        'XP',
        '2003',
        'Vista',
        '7',
        '8',
        '8.1',
        '8.1 RT',
        '10',
        '11',
        '12',
    ];

    #[\Override]
    public array $customColorsByName = [
        '98' => ColorHelper::WINDOWS_98,
        '2000' => ColorHelper::SYSTEM_PINK,
        'ME' => ColorHelper::SYSTEM_INDIGO,
        'XP' => ColorHelper::WINDOWS_XP,
        '2003' => ColorHelper::SYSTEM_GRAY,
        'Vista' => ColorHelper::SYSTEM_YELLOW,
        '7' => ColorHelper::SYSTEM_GREEN,
        '8' => ColorHelper::SYSTEM_RED,
        '8.1' => ColorHelper::SYSTEM_PURPLE,
        '8.1 RT' => ColorHelper::SYSTEM_PURPLE,
        '10' => ColorHelper::SYSTEM_BLUE,
        '11' => ColorHelper::SYSTEM_ORANGE,
        '12' => ColorHelper::SYSTEM_PINK,
    ];
}
