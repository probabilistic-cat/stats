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

    protected array $fileUrls = [
        self::SUBCATEGORY_ALL => 'https://gs.statcounter.com/android-version-market-share/mobile-tablet/worldwide/'
            .'chart.php?device=Mobile%20%26%20Tablet&device_hidden=mobile%2Btablet&multi-device=true'
            .'&statType_hidden=android_version&region_hidden=ww&granularity=monthly&statType=Android%20Version'
            .'&region=Worldwide&fromInt=201706&toInt='.self::DUMMY_YEAR.self::DUMMY_MONTH
            .'&fromMonthYear=2017-06&toMonthYear='.self::DUMMY_YEAR.'-'.self::DUMMY_MONTH.'&csv=1',
        self::SUBCATEGORY_MOBILE => 'https://gs.statcounter.com/android-version-market-share/mobile/worldwide/'
            .'chart.php?device=Mobile&device_hidden=mobile'
            .'&statType_hidden=android_version&region_hidden=ww&granularity=monthly&statType=Android%20Version'
            .'&region=Worldwide&fromInt=201706&toInt='.self::DUMMY_YEAR.self::DUMMY_MONTH
            .'&fromMonthYear=2017-06&toMonthYear='.self::DUMMY_YEAR.'-'.self::DUMMY_MONTH.'&csv=1',
        self::SUBCATEGORY_TABLET => 'https://gs.statcounter.com/android-version-market-share/tablet/worldwide/'
            .'chart.php?device=Tablet&device_hidden=tablet'
            .'&statType_hidden=android_version&region_hidden=ww&granularity=monthly&statType=Android%20Version'
            .'&region=Worldwide&fromInt=201706&toInt='.self::DUMMY_YEAR.self::DUMMY_MONTH
            .'fromMonthYear=2017-06&toMonthYear='.self::DUMMY_YEAR.'-'.self::DUMMY_MONTH.'&csv=1',
    ];
    protected array $fileNames = [
        self::SUBCATEGORY_ALL => 'android_version-ww-monthly-201706-'.self::DUMMY_YEAR.self::DUMMY_MONTH.'.csv',
        self::SUBCATEGORY_MOBILE => 'android_version_mobile-ww-monthly-201706-'.self::DUMMY_YEAR.self::DUMMY_MONTH.'.csv',
        self::SUBCATEGORY_TABLET => 'android_version_tablet-ww-monthly-201706-'.self::DUMMY_YEAR.self::DUMMY_MONTH.'.csv',
    ];

    public string $nameSeparator = '.';

    public function __construct() {
        $this->customColorsByName = self::getCustomColorsByNumberName();
    }
}
