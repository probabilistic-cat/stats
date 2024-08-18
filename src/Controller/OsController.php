<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\ContentViewDTO;
use App\DTO\SubcategoryViewDTO;
use App\Profile\BaseProfile;
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
        return $this->getOsResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    #[Route('/os_desktop', name: self::ROUTE_NAME_DESKTOP)]
    public function desktop(): Response {
        return $this->getOsResponse(subcategory: BaseProfile::SUBCATEGORY_DESKTOP);
    }

    #[Route('/os_mobile', name: self::ROUTE_NAME_MOBILE)]
    public function mobile(): Response {
        return $this->getOsResponse(subcategory: BaseProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/os_tablet', name: self::ROUTE_NAME_TABLET)]
    public function tablet(): Response {
        return $this->getOsResponse(subcategory: BaseProfile::SUBCATEGORY_TABLET);
    }

    #[Route('/os_console', name: self::ROUTE_NAME_CONSOLE)]
    public function console(): Response {
        return $this->getOsResponse(subcategory: BaseProfile::SUBCATEGORY_CONSOLE);
    }

    private function getOsResponse(string $subcategory): Response {
        $contentView = new ContentViewDTO(
            categoryName: 'Operating system',
            categoryRoute: $this->generateUrl(self::ROUTE_NAME_ALL),
            subcategories: [
                new SubcategoryViewDTO(
                    name: 'All',
                    route: $this->generateUrl(self::ROUTE_NAME_ALL),
                    isCurrent: $subcategory === BaseProfile::SUBCATEGORY_ALL,
                ),
                new SubcategoryViewDTO(
                    name: 'Desktop',
                    route: $this->generateUrl(self::ROUTE_NAME_DESKTOP),
                    isCurrent: $subcategory === BaseProfile::SUBCATEGORY_DESKTOP,
                ),
                new SubcategoryViewDTO(
                    name: 'Mobile',
                    route: $this->generateUrl(self::ROUTE_NAME_MOBILE),
                    isCurrent: $subcategory === BaseProfile::SUBCATEGORY_MOBILE,
                ),
                new SubcategoryViewDTO(
                    name: 'Tablet',
                    route: $this->generateUrl(self::ROUTE_NAME_TABLET),
                    isCurrent: $subcategory === BaseProfile::SUBCATEGORY_TABLET,
                ),
                new SubcategoryViewDTO(
                    name: 'Console',
                    route: $this->generateUrl(self::ROUTE_NAME_CONSOLE),
                    isCurrent: $subcategory === BaseProfile::SUBCATEGORY_CONSOLE,
                ),
            ],
        );

        return $this->getResponse(
            profile: new OsProfile(),
            subcategory: $subcategory,
            contentView: $contentView,
        );
    }
}
