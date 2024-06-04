<?php

declare(strict_types=1);

namespace App\Repository\Profile;

use App\Repository\Consts;

abstract class BaseProfile
{
    public const string COLOR_OTHER = '#d8d8dc';
    public const array NAMES_OTHER = ['Unknown', 'Other'];
    public const string PREFIX_OTHER = '';

    public const string SORT_PERCENT_ASC = 'sort_percent_asc';
    public const string SORT_NAME_ASC = 'sort_name_asc';

    public string $category;
    /** @var array<string> */
    public array $subcategoriesLinks;

    // decoder properties
    /** @var array<string, string> */
    protected array $filenames;
    public string $prefix = '';
    public string $nameSeparator = '~';

    /** @var array<string> */
    public array $colors = [
        '#70d7ff', '#ffb33f', '#da8fff', '#30db5b', '#ffd426', '#ff6482', '#67d4cf', '#7d7aff', '#ff6861',
    ];
    /** @var array<string, string> */
    public array $customColorsByName = [];

    public string $sort = self::SORT_NAME_ASC;

    public function getFilePathBySubcategory(string $subcategory): string {
        if (!array_key_exists($subcategory, $this->subcategoriesLinks)) {
            throw new \InvalidArgumentException('Unknown subcategory');
        }

        return Consts::DIR.'/File/'.$this->filenames[$subcategory];
    }

    /**
     * @return array<string, string>
     */
    protected static function getCustomColorsByNumberName(): array {
        $customColors0to10 = [
            0 => '#aeaeb2',
            1 => '#ff6861',
            2 => '#ffb33f',
            3 => '#70d7ff',
            4 => '#30db5b',
            5 => '#da8fff',
            6 => '#ffd426',
            7 => '#ff6482',
            8 => '#67d4cf',
            9 => '#7d7aff',
        ];

        $customColors = [];
        $tens = 3;
        for ($indexTens = 0; $indexTens < $tens; $indexTens++) {
            foreach ($customColors0to10 as $index0to10 => $color) {
                $index = $indexTens * 10 + $index0to10;
                $customColors[(string)$index] = $color;
            }
        }

        return $customColors;
    }
}
