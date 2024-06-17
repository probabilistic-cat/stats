<?php

declare(strict_types=1);

namespace App\Controller;

use App\Profile\OsProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OsController extends BaseController
{
    private const string ROUTE_NAME_ALL = 'app_os_all';
    private const string ROUTE_NAME_DESKTOP = 'app_os_desktop';
    private const string ROUTE_NAME_MOBILE = 'app_os_mobile';
    private const string ROUTE_NAME_TABLET = 'app_os_tablet';
    private const string ROUTE_NAME_CONSOLE = 'app_os_console';

    #[Route('/os_all', name: self::ROUTE_NAME_ALL)]
    public function all(): Response {
        return $this->getOsResponse(subcategory: OsProfile::SUBCATEGORY_ALL);
    }

    #[Route('/os_desktop', name: self::ROUTE_NAME_DESKTOP)]
    public function desktop(): Response {
        return $this->getOsResponse(subcategory: OsProfile::SUBCATEGORY_DESKTOP);
    }

    #[Route('/os_mobile', name: self::ROUTE_NAME_MOBILE)]
    public function mobile(): Response {
        return $this->getOsResponse(subcategory: OsProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/os_tablet', name: self::ROUTE_NAME_TABLET)]
    public function tablet(): Response {
        return $this->getOsResponse(subcategory: OsProfile::SUBCATEGORY_TABLET);
    }

    #[Route('/os_console', name: self::ROUTE_NAME_CONSOLE)]
    public function console(): Response {
        return $this->getOsResponse(subcategory: OsProfile::SUBCATEGORY_CONSOLE);
    }

    private function getOsResponse(string $subcategory): Response {
        $extraContext = [
            'categoryName' => 'Operating systems',
            'categoryRoute' => $this->generateUrl(self::ROUTE_NAME_ALL),
            'subcategoriesNames' => [
                OsProfile::SUBCATEGORY_ALL => 'All',
                OsProfile::SUBCATEGORY_DESKTOP => 'Desktop',
                OsProfile::SUBCATEGORY_MOBILE => 'Mobile',
                OsProfile::SUBCATEGORY_TABLET => 'Tablet',
                OsProfile::SUBCATEGORY_CONSOLE => 'Console',
            ],
            'subcategoriesRoutes' => [
                OsProfile::SUBCATEGORY_ALL => $this->generateUrl(self::ROUTE_NAME_ALL),
                OsProfile::SUBCATEGORY_DESKTOP => $this->generateUrl(self::ROUTE_NAME_DESKTOP),
                OsProfile::SUBCATEGORY_MOBILE => $this->generateUrl(self::ROUTE_NAME_MOBILE),
                OsProfile::SUBCATEGORY_TABLET => $this->generateUrl(self::ROUTE_NAME_TABLET),
                OsProfile::SUBCATEGORY_CONSOLE => $this->generateUrl(self::ROUTE_NAME_CONSOLE),
            ],
        ];

        return $this->getResponse(
            profile: new OsProfile(),
            subcategory: $subcategory,
            extraContext: $extraContext,
        );
    }
}
