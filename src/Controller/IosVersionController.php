<?php

declare(strict_types=1);

namespace App\Controller;

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
        return $this->getIosVersionResponse(subcategory: IosVersionProfile::SUBCATEGORY_ALL);
    }

    #[Route('/ios_version_iphone', name: self::ROUTE_NAME_IPHONE)]
    public function iphone(): Response {
        return $this->getIosVersionResponse(subcategory: IosVersionProfile::SUBCATEGORY_IPHONE);
    }

    #[Route('/ios_version_ipad', name: self::ROUTE_NAME_IPAD)]
    public function ipad(): Response {
        return $this->getIosVersionResponse(subcategory: IosVersionProfile::SUBCATEGORY_IPAD);
    }

    private function getIosVersionResponse(string $subcategory): Response {
        $extraContext = [
            'categoryName' => 'iOS versions',
            'categoryRoute' => $this->generateUrl(self::ROUTE_NAME_ALL),
            'subcategoriesNames' => [
                IosVersionProfile::SUBCATEGORY_ALL => 'All',
                IosVersionProfile::SUBCATEGORY_IPHONE => 'iPhone',
                IosVersionProfile::SUBCATEGORY_IPAD => 'iPad',
            ],
            'subcategoriesRoutes' => [
                IosVersionProfile::SUBCATEGORY_ALL => $this->generateUrl(self::ROUTE_NAME_ALL),
                IosVersionProfile::SUBCATEGORY_IPHONE => $this->generateUrl(self::ROUTE_NAME_IPHONE),
                IosVersionProfile::SUBCATEGORY_IPAD => $this->generateUrl(self::ROUTE_NAME_IPAD),
            ],
        ];

        return $this->getResponse(
            profile: new IosVersionProfile(),
            subcategory: $subcategory,
            extraContext: $extraContext,
        );
    }
}
