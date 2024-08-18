<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\ContentViewDTO;
use App\DTO\SubcategoryViewDTO;
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
        $contentView = new ContentViewDTO(
            categoryName: 'Platform',
            categoryRoute: $this->generateUrl(self::ROUTE_NAME_ALL),
            subcategories: [
                new SubcategoryViewDTO(
                    name: 'All',
                    route: $this->generateUrl(self::ROUTE_NAME_ALL),
                    isCurrent: $subcategory === BaseProfile::SUBCATEGORY_ALL,
                ),
            ],
        );

        return $this->getResponse(
            profile: new PlatformProfile(),
            subcategory: $subcategory,
            contentView: $contentView,
        );
    }
}
