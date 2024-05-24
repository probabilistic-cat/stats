<?php

namespace App\Data;

class MinorVersionDTO
{
    public function __construct(
        public string $minorVersion,
        public float $percent,
        public string $color = '#ffffff',
    ) {}
}