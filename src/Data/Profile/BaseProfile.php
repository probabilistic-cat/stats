<?php

declare(strict_types=1);

namespace App\Data\Profile;

use App\Consts;

abstract class BaseProfile
{
    public const string COLOR_OTHER = '#d8d8dc';
    public const string VERSION_OTHER = 'Other';
    public const string PREFIX_OTHER = '';
    protected string $filename;
    public string $versionPrefix = '';
    public string $versionSeparator = '~';

    /** @var array{string} */
    public array $colors = [
        '#70d7ff', '#ffb33f', '#da8fff', '#30db5b', '#ffd426', '#ff6482', '#67d4cf', '#7d7aff', '#ff6861',
    ];

    /** @var array{string: string}|null */
    public ?array $colorByVersion = null;

    public function getFilePath(): string {
        return Consts::DIR_SRC.'/Data/File/'.$this->filename;
    }
}
