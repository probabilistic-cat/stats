<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\Profile\BrowserProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BrowserController extends BaseController
{
    #[Route('/browser_all', name: 'app_browser_all')]
    public function all(): Response {
        return $this->getBrowserResponse(subcategory: BrowserProfile::SUBCATEGORY_ALL);
    }

    #[Route('/browser_desktop', name: 'app_browser_desktop')]
    public function desktop(): Response {
        return $this->getBrowserResponse(subcategory: BrowserProfile::SUBCATEGORY_DESKTOP);
    }

    #[Route('/browser_mobile', name: 'app_browser_mobile')]
    public function mobile(): Response {
        return $this->getBrowserResponse(subcategory: BrowserProfile::SUBCATEGORY_MOBILE);
    }

    #[Route('/browser_tablet', name: 'app_browser_tablet')]
    public function tablet(): Response {
        return $this->getBrowserResponse(subcategory: BrowserProfile::SUBCATEGORY_TABLET);
    }

    #[Route('/browser_console', name: 'app_browser_console')]
    public function console(): Response {
        return $this->getBrowserResponse(subcategory: BrowserProfile::SUBCATEGORY_CONSOLE);
    }

    private function getBrowserResponse(string $subcategory): Response {
        return $this->getResponse(
            profile: new BrowserProfile(),
            subcategory: $subcategory,
            categoryLink: $this->generateUrl('app_browser_all'),
        );
    }
}
