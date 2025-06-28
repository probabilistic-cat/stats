<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\ContentViewDTO;
use App\DTO\SubcategoryViewDTO;
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

    #[Route('/vendor_all', name: self::ROUTE_NAME_ALL)]
    public function all(): Response {
        return $this->getVendorResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    #[Route('/vendor_mobile', name: self::ROUTE_NAME_MOBILE)]
    public function mobile(): Response {
        return $this->getVendorResponse(subcategory: BaseProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/vendor_tablet', name: self::ROUTE_NAME_TABLET)]
    public function tablet(): Response {
        return $this->getVendorResponse(subcategory: BaseProfile::SUBCATEGORY_TABLET);
    }

    #[Route('/vendor_console', name: self::ROUTE_NAME_CONSOLE)]
    public function console(): Response {
        return $this->getVendorResponse(subcategory: BaseProfile::SUBCATEGORY_CONSOLE);
    }

    private function getVendorResponse(string $subcategory): Response {
        $contentView = new ContentViewDTO(
            categoryName: 'Device vendor',
            categoryRoute: $this->generateUrl(self::ROUTE_NAME_ALL),
            subcategories: [
                new SubcategoryViewDTO(
                    name: 'All',
                    route: $this->generateUrl(self::ROUTE_NAME_ALL),
                    isCurrent: $subcategory === BaseProfile::SUBCATEGORY_ALL,
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
            profile: new VendorProfile(),
            subcategory: $subcategory,
            contentView: $contentView,
        );
    }
}
