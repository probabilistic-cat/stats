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
    private const string ROUTE_NAME_MOBILE = 'app_ios_version_iphone';
    private const string ROUTE_NAME_TABLET = 'app_ios_version_ipad';

    protected string $categoryName = 'iOS version';

    #[Route('/ios_version_all', name: self::ROUTE_NAME_ALL)]
    public function all(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    #[Route('/ios_version_iphone', name: self::ROUTE_NAME_MOBILE)]
    public function iphone(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/ios_version_ipad', name: self::ROUTE_NAME_TABLET)]
    public function ipad(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_TABLET);
    }

    protected function getCategoryRoute(): string {
        return self::ROUTE_NAME_ALL;
    }

    protected function getProfile(): BaseProfile {
        return new IosVersionProfile();
    }

    protected function getRoutesByName(): array {
        return [
            BaseProfile::SUBCATEGORY_ALL => self::ROUTE_NAME_ALL,
            BaseProfile::SUBCATEGORY_MOBILE => self::ROUTE_NAME_MOBILE,
            BaseProfile::SUBCATEGORY_TABLET => self::ROUTE_NAME_TABLET,
        ];
    }
}
