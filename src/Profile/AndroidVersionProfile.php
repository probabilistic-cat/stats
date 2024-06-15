<?php

declare(strict_types=1);

namespace App\Profile;

class AndroidVersionProfile extends BaseProfile
{
    public const string SUBCATEGORY_ALL = 'all';
    public const string SUBCATEGORY_MOBILE = 'mobile';
    public const string SUBCATEGORY_TABLET = 'tablet';

    public string $category = 'android_version';
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
        self::SUBCATEGORY_MOBILE,
        self::SUBCATEGORY_TABLET,
    ];

    protected array $filenames = [
        self::SUBCATEGORY_ALL => 'android_version-ww-monthly-201706-202404.csv',
        self::SUBCATEGORY_MOBILE => 'android_version_mobile-ww-monthly-201706-202404.csv',
        self::SUBCATEGORY_TABLET => 'android_version_tablet-ww-monthly-201706-202404.csv',
    ];
    public string $nameSeparator = '.';

    public function __construct() {
        $this->customColorsByName = self::getCustomColorsByNumberName();
    }
}
