<?php

declare(strict_types=1);

namespace App\Profile;

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
        'AOL' => '#67d4cf',
        'AVG Search' => '#ffd426',
        'Ask Jeeves' => '#ff6861',
        'Babylon' => '#30db5b',
        'Baidu' => '#7d7aff',
        'bing' => '#70d7ff',
        'CocCoc' => '#30db5b',
        'Conduit' => '#70d7ff',
        'Daum' => '#ff6482',
        'DuckDuckGo' => '#ffb33f',
        'Ecosia' => '#30db5b',
        'Google' => '#30db5b',
        'Haosou' => '#30db5b',
        'MSN' => '#ffb33f',
        'Mail.ru' => '#67d4cf',
        'Naver' => '#03c95a',
        'Seznam' => '#ff6482',
        'Shenma' => '#ffb33f',
        'Sogou' => '#ff6482',
        'StartPagina (Google)' => '#ffb33f',
        'SweetIM' => '#7d7aff',
        'Webcrawler' => '#ffb33f',
        'Windows Live' => '#70d7ff',
        'YANDEX RU' => '#ffd426',
        'YANDEX' => '#ffd426',
        'Yahoo!' => '#da8fff',
    ];
}
