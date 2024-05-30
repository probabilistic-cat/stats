<?php

declare(strict_types=1);

namespace App\Repository\Data;

class Version
{
    public function __construct(
        public string $version,
        public float $percent,
        public string $prefix = '',
        public string $color = '#ffffff',
        /** @var Version[] $minorVersions */
        public array $minorVersions = [],
    ) {}
}
