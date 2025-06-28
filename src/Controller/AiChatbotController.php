<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\ContentViewDTO;
use App\DTO\SubcategoryViewDTO;
use App\Profile\AiChatbotProfile;
use App\Profile\BaseProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AiChatbotController extends BaseController
{
    private const string ROUTE_NAME_ALL = 'app_ai_chatbot_all';

    #[Route('/ai_chatbot_all', name: self::ROUTE_NAME_ALL)]
    public function desktop(): Response {
        return $this->getAiChatborResponse(subcategory: BaseProfile::SUBCATEGORY_ALL);
    }

    private function getAiChatborResponse(string $subcategory): Response {
        $contentView = new ContentViewDTO(
            categoryName: 'AI chatbot',
            categoryRoute: $this->generateUrl(self::ROUTE_NAME_ALL),
            subcategories: [
                new SubcategoryViewDTO(
                    name: 'All',
                    route: $this->generateUrl(self::ROUTE_NAME_ALL),
                    isCurrent: $subcategory === BaseProfile::SUBCATEGORY_ALL,
                ),
            ],
        );

        return $this->getResponse(
            profile: new AiChatbotProfile(),
            subcategory: $subcategory,
            contentView: $contentView,
        );
    }
}
