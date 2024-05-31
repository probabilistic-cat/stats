<?php

declare(strict_types=1);

namespace App\Repository\Profile;

use App\Repository\Consts;

abstract class BaseProfile
{
    public const string COLOR_OTHER = '#d8d8dc';
    public const array VERSIONS_OTHER = ['Unknown', 'Other'];
    public const string PREFIX_OTHER = '';

    public const string SORT_PERCENT_ASC = 'sort_percent_asc';
    public const string SORT_VERSION_ASC = 'sort_version_asc';

    public string $category;
    /** @var array{string} */
    public array $subcategoriesLinks;

    // decoder properties
    /** @var array{string: string} */
    protected array $filenames;
    public string $versionPrefix = '';
    public string $versionSeparator = '~';

    /** @var array{string} */
    public array $colors = [
        '#70d7ff', '#ffb33f', '#da8fff', '#30db5b', '#ffd426', '#ff6482', '#67d4cf', '#7d7aff', '#ff6861',
    ];
    /** @var array{string: string} */
    public array $customColorsByVersion = [];

    public string $sort;

    public function getFilePathBySubcategory(string $subcategory): string {
        if (!array_key_exists($subcategory, $this->subcategoriesLinks)) {
            throw new \InvalidArgumentException('Unknown subcategory');
        }

        return Consts::DIR.'/File/'.$this->filenames[$subcategory];
    }
}
