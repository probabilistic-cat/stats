<?php

declare(strict_types=1);

namespace App\Data\Decoder;

class VersionDTO
{
    public const string VERSION_OTHER = 'Other';
    public const string PREFIX_OTHER = '';

    public function __construct(
        public string $version,
        public float $percent,
        public string $prefix = '',
        public string $color = '#ffffff',
        /** @var VersionDTO[] $minorVersions */
        public array $minorVersions = [],
    ) {}
}
