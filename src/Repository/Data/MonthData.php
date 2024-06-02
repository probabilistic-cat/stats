<?php

declare(strict_types=1);

namespace App\Repository\Data;

class MonthData
{
    /** @var array<Version> */
    public array $versions = [];

    public function __construct(
        public \DateTime $date,
    ) {}
}
