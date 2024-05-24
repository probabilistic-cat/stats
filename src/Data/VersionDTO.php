<?php

declare(strict_types=1);

namespace App\Data;

class VersionDTO
{
    public const string VERSION_OTHER = 'Other';

    public function __construct(
        public string $version,
        public float $percent,
        public string $prefix = '',
        public string $color = '#ffffff',
        /** @var VersionDTO[] $minorVersions */
        public array $minorVersions = [],
    ) {}
}
