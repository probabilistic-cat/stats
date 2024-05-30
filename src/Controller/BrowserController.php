<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\Data\DataFileDecoder;
use App\Repository\Profile\BrowserProfile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BrowserController extends AbstractController
{
    #[Route('/browser_all', name: 'app_browser_all')]
    public function browserAll(DataFileDecoder $decoder): Response {
        return $this->getResponse(decoder: $decoder, subcategory: BrowserProfile::SUBCATEGORY_ALL);
    }

    #[Route('/browser_desktop', name: 'app_browser_desktop')]
    public function browserDesktop(DataFileDecoder $decoder): Response {
        return $this->getResponse(decoder: $decoder, subcategory: BrowserProfile::SUBCATEGORY_DESKTOP);
    }

    #[Route('/browser_mobile', name: 'app_browser_mobile')]
    public function browserMobile(DataFileDecoder $decoder): Response {
        return $this->getResponse(decoder: $decoder, subcategory: BrowserProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/browser_tablet', name: 'app_browser_tablet')]
    public function browserTablet(DataFileDecoder $decoder): Response {
        return $this->getResponse(decoder: $decoder, subcategory: BrowserProfile::SUBCATEGORY_TABLET);
    }

    #[Route('/browser_console', name: 'app_browser_console')]
    public function browserConsole(DataFileDecoder $decoder): Response {
        return $this->getResponse(decoder: $decoder, subcategory: BrowserProfile::SUBCATEGORY_CONSOLE);
    }

    private function getResponse(DataFileDecoder $decoder, string $subcategory): Response {
        $profile = new BrowserProfile();
        $filepath = $profile->getFilePathBySubcategory(subcategory: $subcategory);
        $data = $decoder->decode(profile: $profile, filepath: $filepath);

        return $this->render('content.html.twig', [
            'category' => $profile->category,
            'categoryLink' => $this->generateUrl('app_browser_all'),
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
