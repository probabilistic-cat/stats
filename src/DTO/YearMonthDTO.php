<?php

declare(strict_types=1);

namespace App\DTO;

readonly class YearMonthDTO
{
    public function __construct(
        public int $year,
        public int $month,
    ) {}
}
