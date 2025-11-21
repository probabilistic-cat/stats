<?php

declare(strict_types=1);

namespace App\Profile;

use App\Helper\ColorHelper;

class PlatformProfile extends BaseProfile
{
    public string $category = 'comparison';
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
    ];

    protected string $marketShareUrlPart = 'platform-market-share';
    protected string $statType = 'Platform Comparison';
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_ALL => 2009,
    ];
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_ALL => 1,
    ];
    protected bool $isUrlPathShort = true;

    public array $customColorsByName = [
        'Console' => ColorHelper::SYSTEM_YELLOW,
        'Desktop' => ColorHelper::SYSTEM_BLUE,
        'Mobile' => ColorHelper::SYSTEM_GREEN,
        'Tablet' => ColorHelper::SYSTEM_PINK,
    ];

    #[\Override]
    protected function getUrlDevicePart(string $subcategory, string $separator, bool $ucfirst = false): string {
        $devices = [];
        $platforms = [
            self::SUBCATEGORY_DESKTOP,
            self::SUBCATEGORY_MOBILE,
            self::SUBCATEGORY_TABLET,
            self::SUBCATEGORY_CONSOLE,
        ];
        foreach ($platforms as $platform) {
            $devices[] = $ucfirst ? ucfirst($platform) : $platform;
        }

        return implode($separator, $devices);
    }
}
