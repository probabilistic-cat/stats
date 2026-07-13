<?php

declare(strict_types=1);

namespace App\Profile;

use App\Enum\Color;

class PlatformProfile extends BaseProfile
{
    #[\Override]
    public string $category = 'comparison';
    #[\Override]
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
    ];

    #[\Override]
    protected string $marketShareUrlPart = 'platform-market-share';
    #[\Override]
    protected string $statType = 'Platform Comparison';
    #[\Override]
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_ALL => 2009,
    ];
    #[\Override]
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_ALL => 1,
    ];
    #[\Override]
    protected bool $isUrlPathShort = true;

    #[\Override]
    public array $customColorsByName = [
        'Console' => Color::SYSTEM_YELLOW->value,
        'Desktop' => Color::SYSTEM_BLUE->value,
        'Mobile' => Color::SYSTEM_GREEN->value,
        'Tablet' => Color::SYSTEM_PINK->value,
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
