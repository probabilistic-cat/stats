<?php

declare(strict_types=1);

namespace App\Profile;

class AndroidVersionProfile extends BaseProfile
{
    public string $category = 'android_version';
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
        self::SUBCATEGORY_MOBILE,
        self::SUBCATEGORY_TABLET,
    ];

    protected string $marketShareUrlPart = 'android-version-market-share';
    protected string $statType = 'Android Version';
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_ALL => 2017,
        self::SUBCATEGORY_MOBILE => 2017,
        self::SUBCATEGORY_TABLET => 2017,
    ];
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_ALL => 6,
        self::SUBCATEGORY_MOBILE => 6,
        self::SUBCATEGORY_TABLET => 6,
    ];

    public string $nameSeparator = '.';

    public function __construct() {
        $this->customColorsByName = self::getCustomColorsByNumberName();
    }
}
