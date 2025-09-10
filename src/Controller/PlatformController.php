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

    protected string $categoryName = 'Platform';

    #[Route('/platform_all', name: self::ROUTE_NAME_ALL)]
    public function desktop(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    protected function getCategoryRoute(): string {
        return $this->generateUrl(self::ROUTE_NAME_ALL);
    }

    protected function getProfile(): BaseProfile {
        return new PlatformProfile();
    }

    protected function getRoutesByName(): array {
        return [
            BaseProfile::SUBCATEGORY_ALL => self::ROUTE_NAME_ALL,
        ];
    }
}
