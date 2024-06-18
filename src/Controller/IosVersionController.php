<?php

declare(strict_types=1);

namespace App\Controller;

use App\Profile\BaseProfile;
use App\Profile\IosVersionProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IosVersionController extends BaseController
{
    private const string ROUTE_NAME_ALL = 'app_ios_version_all';
    private const string ROUTE_NAME_IPHONE = 'app_ios_version_iphone';
    private const string ROUTE_NAME_IPAD = 'app_ios_version_ipad';

    #[Route('/ios_version_all', name: self::ROUTE_NAME_ALL)]
    public function all(): Response {
        return $this->getIosVersionResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    #[Route('/ios_version_iphone', name: self::ROUTE_NAME_IPHONE)]
    public function iphone(): Response {
        return $this->getIosVersionResponse(subcategory: BaseProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/ios_version_ipad', name: self::ROUTE_NAME_IPAD)]
    public function ipad(): Response {
        return $this->getIosVersionResponse(subcategory: BaseProfile::SUBCATEGORY_TABLET);
    }

    private function getIosVersionResponse(string $subcategory): Response {
        $extraContext = [
            'categoryName' => 'iOS version',
            'categoryRoute' => $this->generateUrl(self::ROUTE_NAME_ALL),
            'subcategoriesNames' => [
                BaseProfile::SUBCATEGORY_ALL => 'All',
                BaseProfile::SUBCATEGORY_MOBILE => 'iPhone',
                BaseProfile::SUBCATEGORY_TABLET => 'iPad',
            ],
            'subcategoriesRoutes' => [
                BaseProfile::SUBCATEGORY_ALL => $this->generateUrl(self::ROUTE_NAME_ALL),
                BaseProfile::SUBCATEGORY_MOBILE => $this->generateUrl(self::ROUTE_NAME_IPHONE),
                BaseProfile::SUBCATEGORY_TABLET => $this->generateUrl(self::ROUTE_NAME_IPAD),
            ],
        ];

        return $this->getResponse(
            profile: new IosVersionProfile(),
            subcategory: $subcategory,
            extraContext: $extraContext,
        );
    }
}
