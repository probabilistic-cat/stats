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

    protected string $categoryName = 'Search engine';

    #[Route('/search_engine_all', name: self::ROUTE_NAME_ALL)]
    public function all(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    #[Route('/search_engine_desktop', name: self::ROUTE_NAME_DESKTOP)]
    public function desktop(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_DESKTOP);
    }

    #[Route('/search_engine_mobile', name: self::ROUTE_NAME_MOBILE)]
    public function mobile(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/search_engine_tablet', name: self::ROUTE_NAME_TABLET)]
    public function tablet(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_TABLET);
    }

    #[Route('/search_engine_console', name: self::ROUTE_NAME_CONSOLE)]
    public function console(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_CONSOLE);
    }

    protected function getCategoryRoute(): string {
        return self::ROUTE_NAME_ALL;
    }

    protected function getProfile(): BaseProfile {
        return new SearchEngineProfile();
    }

    protected function getRoutesByName(): array {
        return [
            BaseProfile::SUBCATEGORY_ALL => self::ROUTE_NAME_ALL,
            BaseProfile::SUBCATEGORY_DESKTOP => self::ROUTE_NAME_DESKTOP,
            BaseProfile::SUBCATEGORY_MOBILE => self::ROUTE_NAME_MOBILE,
            BaseProfile::SUBCATEGORY_TABLET => self::ROUTE_NAME_TABLET,
            BaseProfile::SUBCATEGORY_CONSOLE => self::ROUTE_NAME_CONSOLE,
        ];
    }
}
