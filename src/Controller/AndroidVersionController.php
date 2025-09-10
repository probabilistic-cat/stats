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

    protected string $categoryName = 'Android version';

    #[Route('/android_version_all', name: self::ROUTE_NAME_ALL)]
    public function all(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    #[Route('/android_version_mobile', name: self::ROUTE_NAME_MOBILE)]
    public function mobile(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/android_version_tablet', name: self::ROUTE_NAME_TABLET)]
    public function tablet(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_TABLET);
    }

    protected function getCategoryRoute(): string {
        return $this->generateUrl(self::ROUTE_NAME_ALL);
    }

    protected function getProfile(): BaseProfile {
        return new AndroidVersionProfile();
    }

    protected function getRoutesByName(): array {
        return [
            BaseProfile::SUBCATEGORY_ALL => self::ROUTE_NAME_ALL,
            BaseProfile::SUBCATEGORY_MOBILE => self::ROUTE_NAME_MOBILE,
            BaseProfile::SUBCATEGORY_TABLET => self::ROUTE_NAME_TABLET,
        ];
    }
}
