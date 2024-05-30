<?php

declare(strict_types=1);

namespace App\Repository\Profile;

class IosVersionProfile extends BaseProfile
{
    public const string SUBCATEGORY_ALL = 'All';
    public const string SUBCATEGORY_IPHONE = 'iPhone';
    public const string SUBCATEGORY_IPAD = 'iPad';

    public string $category = 'iOS versions';
    public array $subcategoriesLinks = [
        self::SUBCATEGORY_ALL => 'app_ios_versions_all',
        self::SUBCATEGORY_IPHONE => 'app_ios_versions_iphone',
        self::SUBCATEGORY_IPAD => 'app_ios_versions_ipad',
    ];

    protected array $filenames = [
        self::SUBCATEGORY_ALL => 'ios_version-ww-monthly-201706-202404.csv',
        self::SUBCATEGORY_IPHONE => 'ios_version_iphone-ww-monthly-201706-202404.csv',
        self::SUBCATEGORY_IPAD => 'ios_version_ipad-ww-monthly-201706-202404.csv',
    ];
    public string $versionPrefix = 'iOS ';
    public string $versionSeparator = '.';
}
