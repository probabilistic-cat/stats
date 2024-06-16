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

    protected array $fileUrls = [
        self::SUBCATEGORY_ALL => 'https://gs.statcounter.com/ios-version-market-share/mobile-tablet/worldwide/'
            .'chart.php?device=Mobile%20%26%20Tablet&device_hidden=mobile%2Btablet&multi-device=true'
            .'&statType_hidden=ios_version&region_hidden=ww&granularity=monthly&statType=iOS%20Version'
            .'&region=Worldwide&fromInt=201706&toInt='.self::DUMMY_YEAR.self::DUMMY_MONTH
            .'&fromMonthYear=2017-06&toMonthYear='.self::DUMMY_YEAR.'-'.self::DUMMY_MONTH.'&csv=1',
        self::SUBCATEGORY_IPHONE => 'https://gs.statcounter.com/ios-version-market-share/mobile/worldwide/'
            .'chart.php?device=Mobile&device_hidden=mobile'
            .'&statType_hidden=ios_version&region_hidden=ww&granularity=monthly&statType=iOS%20Version'
            .'&region=Worldwide&fromInt=201706&toInt='.self::DUMMY_YEAR.self::DUMMY_MONTH
            .'&fromMonthYear=2017-06&toMonthYear='.self::DUMMY_YEAR.'-'.self::DUMMY_MONTH.'&csv=1',
        self::SUBCATEGORY_IPAD => 'https://gs.statcounter.com/ios-version-market-share/tablet/worldwide/'
            .'chart.php?device=Tablet&device_hidden=tablet'
            .'&statType_hidden=ios_version&region_hidden=ww&granularity=monthly&statType=iOS%20Version'
            .'&region=Worldwide&fromInt=201706&toInt='.self::DUMMY_YEAR.self::DUMMY_MONTH
            .'&fromMonthYear=2017-06&toMonthYear='.self::DUMMY_YEAR.'-'.self::DUMMY_MONTH.'&csv=1',
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
