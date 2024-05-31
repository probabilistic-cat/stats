<?php

declare(strict_types=1);

namespace App\Repository\Data;

class MonthData
{
    public const string DATE = 'Date';
    /** @var array{Version} */
    public array $versions = [];

    public function __construct(
        public string $date,
    ) {}
}
