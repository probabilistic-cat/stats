<?php

declare(strict_types=1);

namespace App\Data\Decoder;

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
