<?php

declare(strict_types=1);

namespace App\Controller;

use App\Profile\BaseProfile;
use App\Profile\WindowsVersionProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WindowsVersionController extends BaseController
{
    private const string ROUTE_NAME_DESKTOP = 'app_windows_desktop';

    #[Route('/windows_desktop', name: self::ROUTE_NAME_DESKTOP)]
    public function desktop(): Response {
        return $this->getOsResponse(subcategory: BaseProfile::SUBCATEGORY_DESKTOP);
    }

    private function getOsResponse(string $subcategory): Response {
        $extraContext = [
            'categoryName' => 'Windows versions',
            'categoryRoute' => $this->generateUrl(self::ROUTE_NAME_DESKTOP),
            'subcategoriesNames' => [
                BaseProfile::SUBCATEGORY_DESKTOP => 'Desktop',
            ],
            'subcategoriesRoutes' => [
                BaseProfile::SUBCATEGORY_DESKTOP => $this->generateUrl(self::ROUTE_NAME_DESKTOP),
            ],
        ];

        return $this->getResponse(
            profile: new WindowsVersionProfile(),
            subcategory: $subcategory,
            extraContext: $extraContext,
        );
    }
}
