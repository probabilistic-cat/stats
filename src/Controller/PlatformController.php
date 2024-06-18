<?php

declare(strict_types=1);

namespace App\Controller;

use App\Profile\BaseProfile;
use App\Profile\PlatformProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlatformController extends BaseController
{
    private const string ROUTE_NAME_ALL = 'app_platform_all';

    #[Route('/platform_all', name: self::ROUTE_NAME_ALL)]
    public function desktop(): Response {
        return $this->getPlatformResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    private function getPlatformResponse(string $subcategory): Response {
        $extraContext = [
            'categoryName' => 'Platforms',
            'categoryRoute' => $this->generateUrl(self::ROUTE_NAME_ALL),
            'subcategoriesNames' => [
                BaseProfile::SUBCATEGORY_ALL => 'All',
            ],
            'subcategoriesRoutes' => [
                BaseProfile::SUBCATEGORY_ALL => $this->generateUrl(self::ROUTE_NAME_ALL),
            ],
        ];

        return $this->getResponse(
            profile: new PlatformProfile(),
            subcategory: $subcategory,
            extraContext: $extraContext,
        );
    }
}
