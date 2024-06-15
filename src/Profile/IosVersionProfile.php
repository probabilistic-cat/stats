<?php

declare(strict_types=1);

namespace App\Profile;

class IosVersionProfile extends BaseProfile
{
    public const string SUBCATEGORY_ALL = 'all';
    public const string SUBCATEGORY_IPHONE = 'iphone';
    public const string SUBCATEGORY_IPAD = 'ipad';

    public string $category = 'ios_version';
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
        self::SUBCATEGORY_IPHONE,
        self::SUBCATEGORY_IPAD,
    ];

    protected array $filenames = [
        self::SUBCATEGORY_ALL => 'ios_version-ww-monthly-201706-202404.csv',
        self::SUBCATEGORY_IPHONE => 'ios_version_iphone-ww-monthly-201706-202404.csv',
        self::SUBCATEGORY_IPAD => 'ios_version_ipad-ww-monthly-201706-202404.csv',
    ];
    public string $prefix = 'iOS ';
    public string $nameSeparator = '.';

    public function __construct() {
        $this->customColorsByName = self::getCustomColorsByNumberName();
    }
}
