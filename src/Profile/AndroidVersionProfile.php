<?php

declare(strict_types=1);

namespace App\Profile;

class AndroidVersionProfile extends BaseProfile
{
    public const string SUBCATEGORY_ALL = 'All';
    public const string SUBCATEGORY_MOBILE = 'Mobile';
    public const string SUBCATEGORY_TABLET = 'Tablet';

    public string $category = 'Android versions';
    public array $subcategoriesLinks = [
        self::SUBCATEGORY_ALL => 'app_android_version_all',
        self::SUBCATEGORY_MOBILE => 'app_android_version_mobile',
        self::SUBCATEGORY_TABLET => 'app_android_version_tablet',
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
