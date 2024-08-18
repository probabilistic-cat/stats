<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\ContentViewDTO;
use App\DTO\SubcategoryViewDTO;
use App\Profile\BaseProfile;
use App\Profile\WindowsVersionProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WindowsVersionController extends BaseController
{
    private const string ROUTE_NAME_DESKTOP = 'app_windows_desktop';

    #[Route('/windows_desktop', name: self::ROUTE_NAME_DESKTOP)]
    public function desktop(): Response {
        return $this->getWindowsResponse(subcategory: BaseProfile::SUBCATEGORY_DESKTOP);
    }

    private function getWindowsResponse(string $subcategory): Response {
        $contentView = new ContentViewDTO(
            categoryName: 'Windows version',
            categoryRoute: $this->generateUrl(self::ROUTE_NAME_DESKTOP),
            subcategories: [
                new SubcategoryViewDTO(
                    name: 'Desktop',
                    route: $this->generateUrl(self::ROUTE_NAME_DESKTOP),
                    isCurrent: $subcategory === BaseProfile::SUBCATEGORY_DESKTOP,
                ),
            ],
        );

        return $this->getResponse(
            profile: new WindowsVersionProfile(),
            subcategory: $subcategory,
            contentView: $contentView,
        );
    }
}
