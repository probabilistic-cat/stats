<?php

declare(strict_types=1);

namespace App\Profile;

use App\Helper\ColorHelper;

class VendorProfile extends BaseProfile
{
    public string $category = 'vendor';
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
        self::SUBCATEGORY_MOBILE,
        self::SUBCATEGORY_TABLET,
        self::SUBCATEGORY_CONSOLE,
    ];

    protected string $marketShareUrlPart = 'vendor-market-share';
    protected string $statType = 'Device Vendor';
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_ALL => 2012,
        self::SUBCATEGORY_MOBILE => 2010,
        self::SUBCATEGORY_TABLET => 2012,
        self::SUBCATEGORY_CONSOLE => 2012,
    ];
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_ALL => 8,
        self::SUBCATEGORY_MOBILE => 3,
        self::SUBCATEGORY_TABLET => 8,
        self::SUBCATEGORY_CONSOLE => 8,
    ];

    public ProfileSort $sort = ProfileSort::PERCENT_ASC;

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
