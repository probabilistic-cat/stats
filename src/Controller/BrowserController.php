<?php

declare(strict_types=1);

namespace App\Controller;

use App\Profile\BaseProfile;
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
        return $this->getBrowserResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    #[Route('/browser_desktop', name: self::ROUTE_NAME_DESKTOP)]
    public function desktop(): Response {
        return $this->getBrowserResponse(subcategory: BaseProfile::SUBCATEGORY_DESKTOP);
    }

    #[Route('/browser_mobile', name: self::ROUTE_NAME_MOBILE)]
    public function mobile(): Response {
        return $this->getBrowserResponse(subcategory: BaseProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/browser_tablet', name: self::ROUTE_NAME_TABLET)]
    public function tablet(): Response {
        return $this->getBrowserResponse(subcategory: BaseProfile::SUBCATEGORY_TABLET);
    }

    #[Route('/browser_console', name: self::ROUTE_NAME_CONSOLE)]
    public function console(): Response {
        return $this->getBrowserResponse(subcategory: BaseProfile::SUBCATEGORY_CONSOLE);
    }

    private function getBrowserResponse(string $subcategory): Response {
        $extraContext = [
            'categoryName' => 'Browsers',
            'categoryRoute' => $this->generateUrl(self::ROUTE_NAME_ALL),
            'subcategoriesNames' => [
                BaseProfile::SUBCATEGORY_ALL => 'All',
                BaseProfile::SUBCATEGORY_DESKTOP => 'Desktop',
                BaseProfile::SUBCATEGORY_MOBILE => 'Mobile',
                BaseProfile::SUBCATEGORY_TABLET => 'Tablet',
                BaseProfile::SUBCATEGORY_CONSOLE => 'Console',
            ],
            'subcategoriesRoutes' => [
                BaseProfile::SUBCATEGORY_ALL => $this->generateUrl(self::ROUTE_NAME_ALL),
                BaseProfile::SUBCATEGORY_DESKTOP => $this->generateUrl(self::ROUTE_NAME_DESKTOP),
                BaseProfile::SUBCATEGORY_MOBILE => $this->generateUrl(self::ROUTE_NAME_MOBILE),
                BaseProfile::SUBCATEGORY_TABLET => $this->generateUrl(self::ROUTE_NAME_TABLET),
                BaseProfile::SUBCATEGORY_CONSOLE => $this->generateUrl(self::ROUTE_NAME_CONSOLE),
            ],
        ];

        return $this->getResponse(
            profile: new BrowserProfile(),
            subcategory: $subcategory,
            extraContext: $extraContext,
        );
    }
}
