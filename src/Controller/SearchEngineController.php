<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\ContentViewDTO;
use App\DTO\SubcategoryViewDTO;
use App\Profile\BaseProfile;
use App\Profile\SearchEngineProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchEngineController extends BaseController
{
    private const string ROUTE_NAME_ALL = 'app_search_engine_all';
    private const string ROUTE_NAME_DESKTOP = 'app_search_engine_desktop';
    private const string ROUTE_NAME_MOBILE = 'app_search_engine_mobile';
    private const string ROUTE_NAME_TABLET = 'app_search_engine_tablet';
    private const string ROUTE_NAME_CONSOLE = 'app_search_engine_console';

    #[Route('/search_engine_all', name: self::ROUTE_NAME_ALL)]
    public function all(): Response {
        return $this->getSearchEngineResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    #[Route('/search_engine_desktop', name: self::ROUTE_NAME_DESKTOP)]
    public function desktop(): Response {
        return $this->getSearchEngineResponse(subcategory: BaseProfile::SUBCATEGORY_DESKTOP);
    }

    #[Route('/search_engine_mobile', name: self::ROUTE_NAME_MOBILE)]
    public function mobile(): Response {
        return $this->getSearchEngineResponse(subcategory: BaseProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/search_engine_tablet', name: self::ROUTE_NAME_TABLET)]
    public function tablet(): Response {
        return $this->getSearchEngineResponse(subcategory: BaseProfile::SUBCATEGORY_TABLET);
    }

    #[Route('/search_engine_console', name: self::ROUTE_NAME_CONSOLE)]
    public function console(): Response {
        return $this->getSearchEngineResponse(subcategory: BaseProfile::SUBCATEGORY_CONSOLE);
    }

    private function getSearchEngineResponse(string $subcategory): Response {
        $contentView = new ContentViewDTO(
            categoryName: 'Search engine',
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
            profile: new SearchEngineProfile(),
            subcategory: $subcategory,
            contentView: $contentView,
        );
    }
}
