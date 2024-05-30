<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\Data\DataFileDecoder;
use App\Repository\Profile\IosVersionProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IosVersionController extends BaseController
{
    #[Route('/ios_version_all', name: 'app_ios_version_all')]
    public function iosVersionsAll(DataFileDecoder $decoder): Response {
        return $this->getIosVersionResponse(subcategory: IosVersionProfile::SUBCATEGORY_ALL);
    }

    #[Route('/ios_version_iphone', name: 'app_ios_version_iphone')]
    public function iosVersionsIphone(DataFileDecoder $decoder): Response {
        return $this->getIosVersionResponse(subcategory: IosVersionProfile::SUBCATEGORY_IPHONE);
    }

    #[Route('/ios_version_ipad', name: 'app_ios_version_ipad')]
    public function iosVersionsIpad(DataFileDecoder $decoder): Response {
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
