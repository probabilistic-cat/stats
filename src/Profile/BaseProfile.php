<?php

declare(strict_types=1);

namespace App\Profile;

use App\Consts;

abstract class BaseProfile
{
    public const string COLOR_OTHER = '#d8d8dc';
    public const array NAMES_OTHER = ['Unknown', 'Other'];
    public const string PREFIX_OTHER = '';

    public const string SORT_PERCENT_ASC = 'sort_percent_asc';
    public const string SORT_NAME_ASC = 'sort_name_asc';

    protected const string DUMMY_YEAR = 'YYYY';
    protected const string DUMMY_MONTH = 'MM';

    public string $category;
    /** @var array<string> */
    public array $subcategories;

    /** @var array<string, string> */
    protected array $fileUrls;
    /** @var array<string, string> */
    protected array $fileNames;

    public string $prefix = '';
    public string $nameSeparator = '~';

    /** @var array<string> */
    public array $colors = [
        '#70d7ff', '#ffb33f', '#da8fff', '#30db5b', '#ffd426', '#ff6482', '#67d4cf', '#7d7aff', '#ff6861',
    ];
    /** @var array<string, string> */
    public array $customColorsByName = [];

    public string $sort = self::SORT_NAME_ASC;

    public function getFilePath(string $subcategory, int $year, int $month): string {
        if (!in_array($subcategory, $this->subcategories, true)) {
            throw new \InvalidArgumentException('Unknown subcategory');
        }

        $filePath = Consts::DIR.'/File/'.$this->fileNames[$subcategory];

        return str_replace(
            [self::DUMMY_YEAR, self::DUMMY_MONTH],
            [(string)$year, mb_str_pad((string)$month, 2, '0', STR_PAD_LEFT)],
            $filePath,
        );
    }

    public function getFileUrl(string $subcategory, int $year, int $month): string {
        if (!array_key_exists($subcategory, $this->fileUrls)) {
            throw new \InvalidArgumentException('Unknown subcategory');
        }

        $fileUrl = $this->fileUrls[$subcategory];

        return str_replace(
            [self::DUMMY_YEAR, self::DUMMY_MONTH],
            [(string)$year, mb_str_pad((string)$month, 2, '0', STR_PAD_LEFT)],
            $fileUrl,
        );
    }

    public function getDataCacheKey(string $subcategory): string {
        return 'data_'.$this->category.'_'.$subcategory;
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
