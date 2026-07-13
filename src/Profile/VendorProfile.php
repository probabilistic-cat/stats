<?php

declare(strict_types=1);

namespace App\Profile;

use App\Helper\ColorHelper;

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
        'Amazon' => ColorHelper::SYSTEM_TEAL,
        'Apple' => ColorHelper::SYSTEM_GRAY,
        'Asus' => ColorHelper::SYSTEM_GRAY,
        'Google' => ColorHelper::SYSTEM_YELLOW,
        'HTC' => ColorHelper::SYSTEM_GREEN,
        'Honor' => ColorHelper::SYSTEM_INDIGO,
        'Huawei' => ColorHelper::SYSTEM_PURPLE,
        'Infinix' => ColorHelper::SYSTEM_GREEN,
        'LG' => ColorHelper::SYSTEM_PINK,
        'Lenovo' => ColorHelper::SYSTEM_RED,
        'Microsoft' => ColorHelper::SYSTEM_BLUE,
        'Motorola' => ColorHelper::SYSTEM_MINT,
        'Nintendo' => ColorHelper::SYSTEM_RED,
        'Nokia' => ColorHelper::SYSTEM_TEAL,
        'OnePlus' => ColorHelper::SYSTEM_RED,
        'Oppo' => ColorHelper::SYSTEM_PURPLE,
        'Realme' => ColorHelper::SYSTEM_YELLOW,
        'Sony' => ColorHelper::SYSTEM_GREEN,
        'Tecno' => ColorHelper::SYSTEM_BLUE,
        'Vivo' => ColorHelper::SYSTEM_RED,
        'Xiaomi' => ColorHelper::SYSTEM_ORANGE,
        'ZTE' => ColorHelper::SYSTEM_BLUE,
        'Samsung' => ColorHelper::SYSTEM_BLUE,
    ];
}
