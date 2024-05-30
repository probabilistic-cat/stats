<?php

declare(strict_types=1);

namespace App\Repository\Helper;

class ColorHelper
{
    private const int COMPONENT_MAX_VALUE = 255;
    private const int COMPONENT_MIN_VALUE = 0;
    private const int COMPONENT_STEP = 16;

    /**
     * @param string $color - hex color
     * @return array{string} - array of hex colors
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
     * @param array{int} $colorRgb
     * @return array{array{int}}
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

    /**
     * @return array{int}
     */
    private static function stringColorToRgb(string $color): array {
        $matches = [];
        $status = preg_match('~^#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$~i', $color, $matches);
        if ($status !== 1) {
            throw new \InvalidArgumentException('Not a color: '.$color);
        }
        array_shift($matches);

        return array_map(static fn (string $component): int => hexdec($component), $matches);
    }

    /**
     * @param array{int} $colorRgb
     */
    private static function colorRgbToStringColor(array $colorRgb): string {
        $stringComponents = array_map(
            static fn (int $component): string => mb_str_pad(dechex($component), 2, '0', STR_PAD_LEFT),
            $colorRgb,
        );

        return '#'.implode('', $stringComponents);
    }
}
