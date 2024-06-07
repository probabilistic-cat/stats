<?php

declare(strict_types=1);

namespace App\Controller;

use App\Profile\IosVersionProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IosVersionController extends BaseController
{
    #[Route('/ios_version_all', name: 'app_ios_version_all')]
    public function all(): Response {
        return $this->getIosVersionResponse(subcategory: IosVersionProfile::SUBCATEGORY_ALL);
    }

    #[Route('/ios_version_iphone', name: 'app_ios_version_iphone')]
    public function iphone(): Response {
        return $this->getIosVersionResponse(subcategory: IosVersionProfile::SUBCATEGORY_IPHONE);
    }

    #[Route('/ios_version_ipad', name: 'app_ios_version_ipad')]
    public function ipad(): Response {
        return $this->getIosVersionResponse(subcategory: IosVersionProfile::SUBCATEGORY_IPAD);
    }

    private function getIosVersionResponse(string $subcategory): Response {
        return $this->getResponse(
            profile: new IosVersionProfile(),
            subcategory: $subcategory,
            categoryLink: $this->generateUrl('app_ios_version_all'),
        );
    }
}
