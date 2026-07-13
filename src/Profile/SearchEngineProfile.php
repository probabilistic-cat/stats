<?php

declare(strict_types=1);

namespace App\Profile;

use App\Enum\Color;

class SearchEngineProfile extends BaseProfile
{
    #[\Override]
    public string $category = 'search_engine';
    #[\Override]
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
        self::SUBCATEGORY_DESKTOP,
        self::SUBCATEGORY_MOBILE,
        self::SUBCATEGORY_TABLET,
        self::SUBCATEGORY_CONSOLE,
    ];

    #[\Override]
    protected string $marketShareUrlPart = 'search-engine-market-share';
    #[\Override]
    protected string $statType = 'Search Engine';
    #[\Override]
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_ALL => 2009,
        self::SUBCATEGORY_DESKTOP => 2009,
        self::SUBCATEGORY_MOBILE => 2009,
        self::SUBCATEGORY_TABLET => 2012,
        self::SUBCATEGORY_CONSOLE => 2012,
    ];
    #[\Override]
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_ALL => 1,
        self::SUBCATEGORY_DESKTOP => 1,
        self::SUBCATEGORY_MOBILE => 1,
        self::SUBCATEGORY_TABLET => 8,
        self::SUBCATEGORY_CONSOLE => 8,
    ];
    #[\Override]
    protected bool $isUrlPathShort = true;

    #[\Override]
    public array $customColorsByName = [
        'AOL' => Color::SYSTEM_MINT->value,
        'AVG Search' => Color::SYSTEM_YELLOW->value,
        'Ask Jeeves' => Color::SYSTEM_RED->value,
        'Babylon' => Color::SYSTEM_GREEN->value,
        'Baidu' => Color::SYSTEM_INDIGO->value,
        'bing' => Color::SYSTEM_BLUE->value,
        'CocCoc' => Color::SYSTEM_GREEN->value,
        'Conduit' => Color::SYSTEM_BLUE->value,
        'Daum' => Color::SYSTEM_PINK->value,
        'DuckDuckGo' => Color::SYSTEM_ORANGE->value,
        'Ecosia' => Color::SYSTEM_GREEN->value,
        'Google' => Color::SYSTEM_GREEN->value,
        'Haosou' => Color::SYSTEM_GREEN->value,
        'MSN' => Color::SYSTEM_ORANGE->value,
        'Mail.ru' => Color::SYSTEM_MINT->value,
        'Naver' => '#03c95a',
        'Seznam' => Color::SYSTEM_PINK->value,
        'Shenma' => Color::SYSTEM_ORANGE->value,
        'Sogou' => Color::SYSTEM_PINK->value,
        'StartPagina (Google)' => Color::SYSTEM_ORANGE->value,
        'SweetIM' => Color::SYSTEM_INDIGO->value,
        'Webcrawler' => Color::SYSTEM_ORANGE->value,
        'Windows Live' => Color::SYSTEM_BLUE->value,
        'YANDEX RU' => Color::SYSTEM_YELLOW->value,
        'YANDEX' => Color::SYSTEM_YELLOW->value,
        'Yahoo!' => Color::SYSTEM_PURPLE->value,
    ];
}
