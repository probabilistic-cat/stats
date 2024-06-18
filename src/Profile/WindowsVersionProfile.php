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

    public string $sort = BaseProfile::SORT_PERCENT_ASC;

    public array $customColorsByName = [
        'Win98' => '#67d4cf',
        'WinME' => '#ffb33f',
        'WinXP' => '#4a89fa',
        'Win2003' => '#aeaeb2',
        'WinVista' => '#ffd426',
        'Win7' => '#30db5b',
        'Win8' => '#ff6861',
        'Win8.1' => '#ff6482',
        'Win10' => '#70d7ff',
        'Win11' => '#da8fff',
    ];
}
