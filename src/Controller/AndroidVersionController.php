<?php

declare(strict_types=1);

namespace App\Controller;

use App\Profile\AndroidVersionProfile;
use App\Profile\BaseProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AndroidVersionController extends BaseController
{
    private const string ROUTE_NAME_ALL = 'app_android_version_all';
    private const string ROUTE_NAME_MOBILE = 'app_android_version_mobile';
    private const string ROUTE_NAME_TABLET = 'app_android_version_tablet';

    #[Route('/android_version_all', name: self::ROUTE_NAME_ALL)]
    public function all(): Response {
        return $this->getIosVersionResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    #[Route('/android_version_mobile', name: self::ROUTE_NAME_MOBILE)]
    public function mobile(): Response {
        return $this->getIosVersionResponse(subcategory: BaseProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/android_version_tablet', name: self::ROUTE_NAME_TABLET)]
    public function tablet(): Response {
        return $this->getIosVersionResponse(subcategory: BaseProfile::SUBCATEGORY_TABLET);
    }

    private function getIosVersionResponse(string $subcategory): Response {
        $extraContext = [
            'categoryName' => 'Android versions',
            'categoryRoute' => $this->generateUrl(self::ROUTE_NAME_ALL),
            'subcategoriesNames' => [
                BaseProfile::SUBCATEGORY_ALL => 'All',
                BaseProfile::SUBCATEGORY_MOBILE => 'Mobile',
                BaseProfile::SUBCATEGORY_TABLET => 'Tablet',
            ],
            'subcategoriesRoutes' => [
                BaseProfile::SUBCATEGORY_ALL => $this->generateUrl(self::ROUTE_NAME_ALL),
                BaseProfile::SUBCATEGORY_MOBILE => $this->generateUrl(self::ROUTE_NAME_MOBILE),
                BaseProfile::SUBCATEGORY_TABLET => $this->generateUrl(self::ROUTE_NAME_TABLET),
            ],
        ];

        return $this->getResponse(
            profile: new AndroidVersionProfile(),
            subcategory: $subcategory,
            extraContext: $extraContext,
        );
    }
}
