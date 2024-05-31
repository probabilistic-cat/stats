<?php

declare(strict_types=1);

namespace App\Repository\Data;

class Version
{
    public string $color = '#ffffff';
    /** @var array{Version} */
    public array $minorVersions = [];

    public function __construct(
        public readonly string $name,
        public float $percent,
        public string $prefix = '',
    ) {}
}
