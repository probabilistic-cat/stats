<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\ContentViewDTO;
use App\DTO\SubcategoryViewDTO;
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
        $contentView = new ContentViewDTO(
            categoryName: 'Browser',
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
            profile: new BrowserProfile(),
            subcategory: $subcategory,
            contentView: $contentView,
        );
    }
}
