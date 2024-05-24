<?php

declare(strict_types=1);

namespace App\Data;

class MonthDataDTO
{
    public const string DATE = 'Date';

    public function __construct(
        public string $date,
        /** @var VersionDTO[] $versions */
        public array $versions = [],
    ) {}
}
