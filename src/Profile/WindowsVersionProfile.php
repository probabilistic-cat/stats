<?php

declare(strict_types=1);

namespace App\Profile;

use App\Enum\Color;
use App\Enum\ProfileSort;

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
        '98' => Color::SYSTEM_MINT->value,
        '2000' => Color::SYSTEM_PINK->value,
        'ME' => Color::SYSTEM_INDIGO->value,
        'XP' => Color::WINDOWS_XP->value,
        '2003' => Color::SYSTEM_GRAY->value,
        'Vista' => Color::SYSTEM_YELLOW->value,
        '7' => Color::SYSTEM_GREEN->value,
        '8' => Color::SYSTEM_RED->value,
        '8.1' => Color::SYSTEM_PURPLE->value,
        '8.1 RT' => Color::SYSTEM_PURPLE->value,
        '10' => Color::SYSTEM_BLUE->value,
        '11' => Color::SYSTEM_ORANGE->value,
        '12' => Color::SYSTEM_PINK->value,
    ];
}
