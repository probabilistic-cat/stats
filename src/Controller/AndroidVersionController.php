<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\Profile\AndroidVersionProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AndroidVersionController extends BaseController
{
    #[Route('/android_version_all', name: 'app_android_version_all')]
    public function all(): Response {
        return $this->getIosVersionResponse(subcategory: AndroidVersionProfile::SUBCATEGORY_ALL);
    }

    #[Route('/android_version_mobile', name: 'app_android_version_mobile')]
    public function mobile(): Response {
        return $this->getIosVersionResponse(subcategory: AndroidVersionProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/android_version_tablet', name: 'app_android_version_tablet')]
    public function tablet(): Response {
        return $this->getIosVersionResponse(subcategory: AndroidVersionProfile::SUBCATEGORY_TABLET);
    }

    private function getIosVersionResponse(string $subcategory): Response {
        return $this->getResponse(
            profile: new AndroidVersionProfile(),
            subcategory: $subcategory,
            categoryLink: $this->generateUrl('app_android_version_all'),
        );
    }
}
