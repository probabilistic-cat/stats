<?php

declare(strict_types=1);

namespace App\Profile;

use App\Enum\ProfileSort;
use App\Helper\ColorHelper;

class WindowsVersionProfile extends BaseProfile
{
    public string $category = 'windows_version';
    public array $subcategories = [
        self::SUBCATEGORY_DESKTOP,
    ];

    protected string $marketShareUrlPart = 'windows-version-market-share';
    protected string $statType = 'Windows Version';
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_DESKTOP => 2009,
    ];
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_DESKTOP => 1,
    ];

    public string $prefix = 'Win';

    public ProfileSort $sort = ProfileSort::CUSTOM;
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
