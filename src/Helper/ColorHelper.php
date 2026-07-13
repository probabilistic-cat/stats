<?php

declare(strict_types=1);

namespace App\Helper;

readonly class ColorHelper
{
    public const string SYSTEM_GRAY = '#aeaeb2';
    public const string SYSTEM_RED = '#ff6861';
    public const string SYSTEM_ORANGE = '#ffb33f';
    public const string SYSTEM_BLUE = '#70d7ff';
    public const string SYSTEM_GREEN = '#30db5b';
    public const string SYSTEM_PURPLE = '#da8fff';
    public const string SYSTEM_YELLOW = '#ffd426';
    public const string SYSTEM_PINK = '#ff6482';
    public const string SYSTEM_MINT = '#67d4cf';
    public const string SYSTEM_INDIGO = '#7d7aff';
    public const string SYSTEM_TEAL = '#2fbacd';

    // dark mode
    //public const string SYSTEM_GRAY = '#aeaeb2';
    //public const string SYSTEM_RED = '#ff4245';
    //public const string SYSTEM_ORANGE = '#ff9230';
    //public const string SYSTEM_BLUE = '#0091ff';
    //public const string SYSTEM_GREEN = '#30d158';
    //public const string SYSTEM_PURPLE = '#db34f2';
    //public const string SYSTEM_YELLOW = '#ffd600';
    //public const string SYSTEM_PINK = '#ff375f';
    //public const string SYSTEM_MINT = '#00dac3';
    //public const string SYSTEM_INDIGO = '#6b5dff';

    public const string OTHER = '#d8d8dc';
    public const string WINDOWS_98 = '#67d4cf';
    public const string WINDOWS_XP = '#7dabf7';
    public const string MAC_OS = '#2dd4bf';

    private const int COMPONENT_MAX_VALUE = 255;
    private const int COMPONENT_MIN_VALUE = 0;
    private const int COMPONENT_STEP = 16;

    /**
     * @param string $color - hex color
     * @return array<string> - array of hex colors
     */
    public static function getGradient(string $color, int $colorsCount): array {
        $colorRgb = self::stringColorToRgb(color: $color);
        $shadesRgb = self::getShadesRgb(colorRgb: $colorRgb, colorsCount: $colorsCount);

        $shades = array_map(
            static fn (array $shadeRgb): string => self::colorRgbToStringColor(colorRgb: $shadeRgb),
            $shadesRgb,
        );

        return array_merge($shades);
    }

    /**
     * @param array<int> $colorRgb
     * @return array<array<int>>
     */
    private static function getShadesRgb(array $colorRgb, int $colorsCount): array {
        $darkCount = (int)floor($colorsCount / 2);
        $lightCount = ($colorsCount % 2 === 0) ? $darkCount - 1 : $darkCount;

        $shadesRgb = [];
        for ($i = $lightCount; $i >= -1 * $darkCount; $i--) {
            $shadeRgb = [];
            foreach ($colorRgb as $colorComponent) {
                $shadeComponent = $colorComponent + $i * self::COMPONENT_STEP;
                if ($shadeComponent < self::COMPONENT_MIN_VALUE) {
                    $shadeComponent = self::COMPONENT_MIN_VALUE;
                }
                if ($shadeComponent > self::COMPONENT_MAX_VALUE) {
                    $shadeComponent = self::COMPONENT_MAX_VALUE;
                }
                $shadeRgb[] = $shadeComponent;
            }

            $shadesRgb[] = $shadeRgb;
        }

        return $shadesRgb;
    }

    /** @return array<int> */
    private static function stringColorToRgb(string $color): array {
        $matches = [];
        $status = preg_match('~^#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$~i', $color, $matches);
        if ($status !== 1) {
            throw new \InvalidArgumentException('Not a color: ' . $color);
        }
        array_shift($matches);

        return array_map(hexdec(...), $matches);
    }

    /** @param array<int> $colorRgb */
    private static function colorRgbToStringColor(array $colorRgb): string {
        $stringComponents = array_map(
            static fn (int $component): string => mb_str_pad(dechex($component), 2, '0', STR_PAD_LEFT),
            $colorRgb,
        );

        return '#' . implode('', $stringComponents);
    }
}
