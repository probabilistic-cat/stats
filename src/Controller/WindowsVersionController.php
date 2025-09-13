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

    protected string $categoryName = 'Windows version';

    #[Route('/windows_desktop', name: self::ROUTE_NAME_DESKTOP)]
    public function desktop(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_DESKTOP);
    }

    protected function getCategoryRoute(): string {
        return self::ROUTE_NAME_DESKTOP;
    }

    protected function getProfile(): BaseProfile {
        return new WindowsVersionProfile();
    }

    protected function getRoutesByName(): array {
        return [
            BaseProfile::SUBCATEGORY_DESKTOP => self::ROUTE_NAME_DESKTOP,
        ];
    }
}
