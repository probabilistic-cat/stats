<?php

namespace App\Data;

class VersionDTO
{
    public const string VERSION_OTHER = 'Other';

    public function __construct(
        public string $version,
        public string $prefix,
        public float $percent,
        public string $color = '#ffffff',
        /** @var MinorVersionDTO[] $minorVersions */
        public array $minorVersions = [],
    ) {}
}