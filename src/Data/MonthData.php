<?php

declare(strict_types=1);

namespace App\Data;

class MonthData
{
    /** @var array<Version> */
    public array $versions = [];

    public function __construct(
        public readonly \DateTime $date,
    ) {}

    public function getDateString(): string {
        return $this->date->format('Y-m');
    }
}
