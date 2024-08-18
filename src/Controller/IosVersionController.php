<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\ContentViewDTO;
use App\DTO\SubcategoryViewDTO;
use App\Profile\BaseProfile;
use App\Profile\IosVersionProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IosVersionController extends BaseController
{
    private const string ROUTE_NAME_ALL = 'app_ios_version_all';
    private const string ROUTE_NAME_MOBILE = 'app_ios_version_iphone';
    private const string ROUTE_NAME_TABLET = 'app_ios_version_ipad';

    #[Route('/ios_version_all', name: self::ROUTE_NAME_ALL)]
    public function all(): Response {
        return $this->getIosVersionResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    #[Route('/ios_version_iphone', name: self::ROUTE_NAME_MOBILE)]
    public function iphone(): Response {
        return $this->getIosVersionResponse(subcategory: BaseProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/ios_version_ipad', name: self::ROUTE_NAME_TABLET)]
    public function ipad(): Response {
        return $this->getIosVersionResponse(subcategory: BaseProfile::SUBCATEGORY_TABLET);
    }

    private function getIosVersionResponse(string $subcategory): Response {
        $contentView = new ContentViewDTO(
            categoryName: 'iOS version',
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
            ],
        );

        return $this->getResponse(
            profile: new IosVersionProfile(),
            subcategory: $subcategory,
            contentView: $contentView,
        );
    }
}
