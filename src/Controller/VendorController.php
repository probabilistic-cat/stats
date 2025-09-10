<?php

declare(strict_types=1);

namespace App\Controller;

use App\Profile\BaseProfile;
use App\Profile\VendorProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VendorController extends BaseController
{
    private const string ROUTE_NAME_ALL = 'app_vendor_all';
    private const string ROUTE_NAME_MOBILE = 'app_vendor_mobile';
    private const string ROUTE_NAME_TABLET = 'app_vendor_tablet';
    private const string ROUTE_NAME_CONSOLE = 'app_vendor_console';

    protected string $categoryName = 'Device vendor';

    #[Route('/vendor_all', name: self::ROUTE_NAME_ALL)]
    public function all(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    #[Route('/vendor_mobile', name: self::ROUTE_NAME_MOBILE)]
    public function mobile(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/vendor_tablet', name: self::ROUTE_NAME_TABLET)]
    public function tablet(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_TABLET);
    }

    #[Route('/vendor_console', name: self::ROUTE_NAME_CONSOLE)]
    public function console(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_CONSOLE);
    }

    protected function getCategoryRoute(): string {
        return $this->generateUrl(self::ROUTE_NAME_ALL);
    }

    protected function getProfile(): BaseProfile {
        return new VendorProfile();
    }

    protected function getRoutesByName(): array {
        return [
            BaseProfile::SUBCATEGORY_ALL => self::ROUTE_NAME_ALL,
            BaseProfile::SUBCATEGORY_MOBILE => self::ROUTE_NAME_MOBILE,
            BaseProfile::SUBCATEGORY_TABLET => self::ROUTE_NAME_TABLET,
            BaseProfile::SUBCATEGORY_CONSOLE => self::ROUTE_NAME_CONSOLE,
        ];
    }
}
