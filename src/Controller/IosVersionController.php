<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\Data\DataFileDecoder;
use App\Repository\Profile\IosVersionProfile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IosVersionController extends AbstractController
{
    #[Route('/ios_version_all', name: 'app_ios_version_all')]
    public function iosVersionsAll(DataFileDecoder $decoder): Response {
        return $this->getResponse(decoder: $decoder, subcategory: IosVersionProfile::SUBCATEGORY_ALL);
    }

    #[Route('/ios_version_iphone', name: 'app_ios_version_iphone')]
    public function iosVersionsIphone(DataFileDecoder $decoder): Response {
        return $this->getResponse(decoder: $decoder, subcategory: IosVersionProfile::SUBCATEGORY_IPHONE);
    }

    #[Route('/ios_version_ipad', name: 'app_ios_version_ipad')]
    public function iosVersionsIpad(DataFileDecoder $decoder): Response {
        return $this->getResponse(decoder: $decoder, subcategory: IosVersionProfile::SUBCATEGORY_IPAD);
    }

    private function getResponse(DataFileDecoder $decoder, string $subcategory): Response {
        $profile = new IosVersionProfile();
        $filepath = $profile->getFilePathBySubcategory($subcategory);
        $data = $decoder->decode(profile: $profile, filepath: $filepath);

        return $this->render('content.html.twig', [
            'category' => $profile->category,
            'categoryLink' => $this->generateUrl('app_ios_version_all'),
            'subcategories' => array_map(
                fn (string $pathName): string => $this->generateUrl($pathName),
                $profile->subcategoriesLinks,
            ),
            'subcategoryCurrent' => $subcategory,
            'data' => $data,
            'hasMinor' => $data->hasMinor,
        ]);
    }
}
