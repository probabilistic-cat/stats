<?php

declare(strict_types=1);

namespace App\Profile;

use App\Enum\Color;

class AiChatbotProfile extends BaseProfile
{
    #[\Override]
    public string $category = 'ai_chatbot';
    #[\Override]
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
    ];

    #[\Override]
    protected string $marketShareUrlPart = 'ai-chatbot-market-share';
    #[\Override]
    protected string $statType = 'AI Chatbot';
    #[\Override]
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_ALL => 2025,
    ];
    #[\Override]
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_ALL => 3,
    ];
    #[\Override]
    protected bool $isUrlPathShort = true;

    #[\Override]
    public array $customColorsByName = [
        'ChatGPT' => Color::SYSTEM_GREEN->value,
        'Perplexity' => Color::SYSTEM_PURPLE->value,
        'Microsoft Copilot' => Color::SYSTEM_BLUE->value,
        'Google Gemini' => Color::SYSTEM_YELLOW->value,
        'Deepseek' => Color::SYSTEM_RED->value,
        'Claude' => Color::SYSTEM_ORANGE->value,
    ];

    #[\Override]
    protected function getUrlDevicePart(string $subcategory, string $separator, bool $ucfirst = false): string {
        $devices = [];
        $platforms = [
            self::SUBCATEGORY_DESKTOP,
            self::SUBCATEGORY_MOBILE,
            self::SUBCATEGORY_TABLET,
            self::SUBCATEGORY_CONSOLE,
        ];
        foreach ($platforms as $platform) {
            $devices[] = $ucfirst ? ucfirst($platform) : $platform;
        }

        return implode($separator, $devices);
    }
}
