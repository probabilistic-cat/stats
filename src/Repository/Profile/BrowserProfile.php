<?php

declare(strict_types=1);

namespace App\Repository\Profile;

class BrowserProfile extends BaseProfile
{
    public const string SUBCATEGORY_ALL = 'All';
    public const string SUBCATEGORY_DESKTOP = 'Desktop';
    public const string SUBCATEGORY_MOBILE = 'Mobile';
    public const string SUBCATEGORY_TABLET = 'Tablet';
    public const string SUBCATEGORY_CONSOLE = 'Console';

    public string $category = 'Browser';
    public array $subcategoriesLinks = [
        self::SUBCATEGORY_ALL => 'app_browser_all',
        self::SUBCATEGORY_DESKTOP => 'app_browser_desktop',
        self::SUBCATEGORY_MOBILE => 'app_browser_mobile',
        self::SUBCATEGORY_TABLET => 'app_browser_tablet',
        self::SUBCATEGORY_CONSOLE => 'app_browser_console',
    ];

    protected array $filenames = [
        self::SUBCATEGORY_ALL => 'browser-ww-monthly-200901-202404.csv',
        self::SUBCATEGORY_DESKTOP => 'browser_desktop-ww-monthly-200901-202404.csv',
        self::SUBCATEGORY_MOBILE => 'browser_mobile-ww-monthly-200901-202404.csv',
        self::SUBCATEGORY_TABLET => 'browser_tablet-ww-monthly-201208-202404.csv',
        self::SUBCATEGORY_CONSOLE => 'browser_console-ww-monthly-201208-202404.csv',
    ];
}
