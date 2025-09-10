<?php

declare(strict_types=1);

namespace App\Controller;

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

    protected string $categoryName = 'Operating system';

    #[Route('/os_all', name: self::ROUTE_NAME_ALL)]
    public function all(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    #[Route('/os_desktop', name: self::ROUTE_NAME_DESKTOP)]
    public function desktop(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_DESKTOP);
    }

    #[Route('/os_mobile', name: self::ROUTE_NAME_MOBILE)]
    public function mobile(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/os_tablet', name: self::ROUTE_NAME_TABLET)]
    public function tablet(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_TABLET);
    }

    #[Route('/os_console', name: self::ROUTE_NAME_CONSOLE)]
    public function console(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_CONSOLE);
    }

    protected function getCategoryRoute(): string {
        return $this->generateUrl(self::ROUTE_NAME_ALL);
    }

    protected function getProfile(): BaseProfile {
        return new OsProfile();
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
