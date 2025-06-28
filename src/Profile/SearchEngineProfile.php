<?php

declare(strict_types=1);

namespace App\Profile;

use App\Helper\ColorHelper;

class SearchEngineProfile extends BaseProfile
{
    public string $category = 'search_engine';
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
        self::SUBCATEGORY_DESKTOP,
        self::SUBCATEGORY_MOBILE,
        self::SUBCATEGORY_TABLET,
        self::SUBCATEGORY_CONSOLE,
    ];

    protected string $marketShareUrlPart = 'search-engine-market-share';
    protected string $statType = 'Search Engine';
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_ALL => 2009,
        self::SUBCATEGORY_DESKTOP => 2009,
        self::SUBCATEGORY_MOBILE => 2009,
        self::SUBCATEGORY_TABLET => 2012,
        self::SUBCATEGORY_CONSOLE => 2012,
    ];
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_ALL => 1,
        self::SUBCATEGORY_DESKTOP => 1,
        self::SUBCATEGORY_MOBILE => 1,
        self::SUBCATEGORY_TABLET => 8,
        self::SUBCATEGORY_CONSOLE => 8,
    ];
    protected bool $isUrlPathShort = true;

    public ProfileSort $sort = ProfileSort::PERCENT_ASC;

    public array $customColorsByName = [
        'AOL' => ColorHelper::SYSTEM_MINT,
        'AVG Search' => ColorHelper::SYSTEM_YELLOW,
        'Ask Jeeves' => ColorHelper::SYSTEM_RED,
        'Babylon' => ColorHelper::SYSTEM_GREEN,
        'Baidu' => ColorHelper::SYSTEM_INDIGO,
        'bing' => ColorHelper::SYSTEM_BLUE,
        'CocCoc' => ColorHelper::SYSTEM_GREEN,
        'Conduit' => ColorHelper::SYSTEM_BLUE,
        'Daum' => ColorHelper::SYSTEM_PINK,
        'DuckDuckGo' => ColorHelper::SYSTEM_ORANGE,
        'Ecosia' => ColorHelper::SYSTEM_GREEN,
        'Google' => ColorHelper::SYSTEM_GREEN,
        'Haosou' => ColorHelper::SYSTEM_GREEN,
        'MSN' => ColorHelper::SYSTEM_ORANGE,
        'Mail.ru' => ColorHelper::SYSTEM_MINT,
        'Naver' => '#03c95a',
        'Seznam' => ColorHelper::SYSTEM_PINK,
        'Shenma' => ColorHelper::SYSTEM_ORANGE,
        'Sogou' => ColorHelper::SYSTEM_PINK,
        'StartPagina (Google)' => ColorHelper::SYSTEM_ORANGE,
        'SweetIM' => ColorHelper::SYSTEM_INDIGO,
        'Webcrawler' => ColorHelper::SYSTEM_ORANGE,
        'Windows Live' => ColorHelper::SYSTEM_BLUE,
        'YANDEX RU' => ColorHelper::SYSTEM_YELLOW,
        'YANDEX' => ColorHelper::SYSTEM_YELLOW,
        'Yahoo!' => ColorHelper::SYSTEM_PURPLE,
    ];
}
