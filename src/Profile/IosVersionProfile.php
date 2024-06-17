<?php

declare(strict_types=1);

namespace App\Profile;

class IosVersionProfile extends BaseProfile
{
    public const string SUBCATEGORY_ALL = 'all';
    public const string SUBCATEGORY_IPHONE = 'mobile';
    public const string SUBCATEGORY_IPAD = 'tablet';

    public string $category = 'ios_version';
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
        self::SUBCATEGORY_IPHONE,
        self::SUBCATEGORY_IPAD,
    ];

    protected string $marketShareUrlPart = 'ios-version-market-share';
    protected string $statType = 'iOS Version';
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_ALL => 2017,
        self::SUBCATEGORY_IPHONE => 2017,
        self::SUBCATEGORY_IPAD => 2017,
    ];
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_ALL => 6,
        self::SUBCATEGORY_IPHONE => 6,
        self::SUBCATEGORY_IPAD => 6,
    ];

    protected array $fileNames = [
        self::SUBCATEGORY_ALL => 'ios_version-ww-monthly-201706-'.self::DUMMY_YEAR.self::DUMMY_MONTH.'.csv',
        self::SUBCATEGORY_IPHONE => 'ios_version_iphone-ww-monthly-201706-'.self::DUMMY_YEAR.self::DUMMY_MONTH.'.csv',
        self::SUBCATEGORY_IPAD => 'ios_version_ipad-ww-monthly-201706-'.self::DUMMY_YEAR.self::DUMMY_MONTH.'.csv',
    ];

    public string $prefix = 'iOS ';
    public string $nameSeparator = '.';

    public function __construct() {
        $this->customColorsByName = self::getCustomColorsByNumberName();
    }
}
