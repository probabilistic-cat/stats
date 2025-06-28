<?php

declare(strict_types=1);

namespace App\Profile;

use App\Helper\ColorHelper;

class AiChatbotProfile extends BaseProfile
{
    public string $category = 'ai_chatbot';
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
    ];

    protected string $marketShareUrlPart = 'ai-chatbot-market-share';
    protected string $statType = 'AI Chatbot';
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_ALL => 2025,
    ];
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_ALL => 3,
    ];
    protected bool $isUrlPathShort = true;

    public ProfileSort $sort = ProfileSort::PERCENT_ASC;

    public array $customColorsByName = [
        'ChatGPT' => ColorHelper::SYSTEM_GREEN,
        'Perplexity' => ColorHelper::SYSTEM_PURPLE,
        'Microsoft Copilot' => ColorHelper::SYSTEM_PINK,
        'Google Gemini' => ColorHelper::SYSTEM_YELLOW,
        'Deepseek' => ColorHelper::SYSTEM_BLUE,
        'Claude' => ColorHelper::SYSTEM_ORANGE,
    ];

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
