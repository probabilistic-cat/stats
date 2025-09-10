<?php

declare(strict_types=1);

namespace App\Controller;

use App\Profile\AiChatbotProfile;
use App\Profile\BaseProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AiChatbotController extends BaseController
{
    private const string ROUTE_NAME_ALL = 'app_ai_chatbot_all';

    protected string $categoryName = 'AI chatbot';

    #[Route('/ai_chatbot_all', name: self::ROUTE_NAME_ALL)]
    public function desktop(): Response {
        return $this->getResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    protected function getCategoryRoute(): string {
        return $this->generateUrl(self::ROUTE_NAME_ALL);
    }

    protected function getProfile(): BaseProfile {
        return new AiChatbotProfile();
    }

    protected function getRoutesByName(): array {
        return [
            BaseProfile::SUBCATEGORY_ALL => self::ROUTE_NAME_ALL,
        ];
    }
}
