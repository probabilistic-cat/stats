<?php

declare(strict_types=1);

namespace App\Controller;

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
        $extraContext = [
            'categoryName' => 'Search Engine',
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
            profile: new SearchEngineProfile(),
            subcategory: $subcategory,
            extraContext: $extraContext,
        );
    }
}
