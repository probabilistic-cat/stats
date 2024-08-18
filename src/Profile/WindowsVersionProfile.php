<?php

declare(strict_types=1);

namespace App\Profile;

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
        '98' => '#67d4cf',
        '2000' => '#ff6482',
        'ME' => '#7d7aff',
        'XP' => '#7dabf7',
        '2003' => '#aeaeb2',
        'Vista' => '#ffd426',
        '7' => '#30db5b',
        '8' => '#ff6861',
        '8.1' => '#da8fff',
        '8.1 RT' => '#da8fff',
        '10' => '#70d7ff',
        '11' => '#ffb33f',
        '12' => '#ff6482',
    ];
}
