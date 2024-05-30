<?php

declare(strict_types=1);

namespace App\Repository\Data;

class MonthData
{
    public const string DATE = 'Date';

    public function __construct(
        public string $date,
        /** @var Version[] $versions */
        public array $versions = [],
    ) {}
}
