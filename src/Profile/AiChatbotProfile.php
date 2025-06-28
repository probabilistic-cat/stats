<?php

declare(strict_types=1);

namespace App\Profile;

class AiChatbotProfile extends BaseProfile
{
    public string $category = 'ai_chatbot';
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
    ];

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
        'ChatGPT' => '#30db5b',
        'Perplexity' => '#da8fff',
        'Microsoft Copilot' => '#ff6482',
        'Google Gemini' => '#ffd426',
        'Deepseek' => '#70d7ff',
        'Claude' => '#ffb33f',
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
