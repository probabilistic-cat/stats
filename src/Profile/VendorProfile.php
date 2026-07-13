<?php

declare(strict_types=1);

namespace App\Profile;

use App\Enum\Color;

class VendorProfile extends BaseProfile
{
    #[\Override]
    public string $category = 'vendor';
    #[\Override]
    public array $subcategories = [
        self::SUBCATEGORY_MOBILE,
        self::SUBCATEGORY_TABLET,
        self::SUBCATEGORY_CONSOLE,
    ];

    #[\Override]
    protected string $marketShareUrlPart = 'vendor-market-share';
    #[\Override]
    protected string $statType = 'Device Vendor';
    #[\Override]
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_MOBILE => 2010,
        self::SUBCATEGORY_TABLET => 2012,
        self::SUBCATEGORY_CONSOLE => 2012,
    ];
    #[\Override]
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_MOBILE => 3,
        self::SUBCATEGORY_TABLET => 8,
        self::SUBCATEGORY_CONSOLE => 8,
    ];

    #[\Override]
    public array $customColorsByName = [
        'Amazon' => Color::SYSTEM_TEAL->value,
        'Apple' => Color::SYSTEM_GRAY->value,
        'Asus' => Color::SYSTEM_GRAY->value,
        'Google' => Color::SYSTEM_YELLOW->value,
        'HTC' => Color::SYSTEM_GREEN->value,
        'Honor' => Color::SYSTEM_INDIGO->value,
        'Huawei' => Color::SYSTEM_PURPLE->value,
        'Infinix' => Color::SYSTEM_GREEN->value,
        'LG' => Color::SYSTEM_PINK->value,
        'Lenovo' => Color::SYSTEM_RED->value,
        'Microsoft' => Color::SYSTEM_BLUE->value,
        'Motorola' => Color::SYSTEM_MINT->value,
        'Nintendo' => Color::SYSTEM_RED->value,
        'Nokia' => Color::SYSTEM_TEAL->value,
        'OnePlus' => Color::SYSTEM_RED->value,
        'Oppo' => Color::SYSTEM_PURPLE->value,
        'Realme' => Color::SYSTEM_YELLOW->value,
        'Sony' => Color::SYSTEM_GREEN->value,
        'Tecno' => Color::SYSTEM_BLUE->value,
        'Vivo' => Color::SYSTEM_RED->value,
        'Xiaomi' => Color::SYSTEM_ORANGE->value,
        'ZTE' => Color::SYSTEM_BLUE->value,
        'Samsung' => Color::SYSTEM_BLUE->value,
    ];
}
