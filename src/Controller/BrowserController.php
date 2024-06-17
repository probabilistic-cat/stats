<?php

declare(strict_types=1);

namespace App\Controller;

use App\Profile\BrowserProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BrowserController extends BaseController
{
    private const string ROUTE_NAME_ALL = 'app_browser_all';
    private const string ROUTE_NAME_DESKTOP = 'app_browser_desktop';
    private const string ROUTE_NAME_MOBILE = 'app_browser_mobile';
    private const string ROUTE_NAME_TABLET = 'app_browser_tablet';
    private const string ROUTE_NAME_CONSOLE = 'app_browser_console';

    #[Route('/browser_all', name: self::ROUTE_NAME_ALL)]
    public function all(): Response {
        return $this->getBrowserResponse(subcategory: BrowserProfile::SUBCATEGORY_ALL);
    }

    #[Route('/browser_desktop', name: self::ROUTE_NAME_DESKTOP)]
    public function desktop(): Response {
        return $this->getBrowserResponse(subcategory: BrowserProfile::SUBCATEGORY_DESKTOP);
    }

    #[Route('/browser_mobile', name: self::ROUTE_NAME_MOBILE)]
    public function mobile(): Response {
        return $this->getBrowserResponse(subcategory: BrowserProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/browser_tablet', name: self::ROUTE_NAME_TABLET)]
    public function tablet(): Response {
        return $this->getBrowserResponse(subcategory: BrowserProfile::SUBCATEGORY_TABLET);
    }

    #[Route('/browser_console', name: self::ROUTE_NAME_CONSOLE)]
    public function console(): Response {
        return $this->getBrowserResponse(subcategory: BrowserProfile::SUBCATEGORY_CONSOLE);
    }

    private function getBrowserResponse(string $subcategory): Response {
        $extraContext = [
            'categoryName' => 'Browsers',
            'categoryRoute' => $this->generateUrl(self::ROUTE_NAME_ALL),
            'subcategoriesNames' => [
                BrowserProfile::SUBCATEGORY_ALL => 'All',
                BrowserProfile::SUBCATEGORY_DESKTOP => 'Desktop',
                BrowserProfile::SUBCATEGORY_MOBILE => 'Mobile',
                BrowserProfile::SUBCATEGORY_TABLET => 'Tablet',
                BrowserProfile::SUBCATEGORY_CONSOLE => 'Console',
            ],
            'subcategoriesRoutes' => [
                BrowserProfile::SUBCATEGORY_ALL => $this->generateUrl(self::ROUTE_NAME_ALL),
                BrowserProfile::SUBCATEGORY_DESKTOP => $this->generateUrl(self::ROUTE_NAME_DESKTOP),
                BrowserProfile::SUBCATEGORY_MOBILE => $this->generateUrl(self::ROUTE_NAME_MOBILE),
                BrowserProfile::SUBCATEGORY_TABLET => $this->generateUrl(self::ROUTE_NAME_TABLET),
                BrowserProfile::SUBCATEGORY_CONSOLE => $this->generateUrl(self::ROUTE_NAME_CONSOLE),
            ],
        ];

        return $this->getResponse(
            profile: new BrowserProfile(),
            subcategory: $subcategory,
            extraContext: $extraContext,
        );
    }
}
