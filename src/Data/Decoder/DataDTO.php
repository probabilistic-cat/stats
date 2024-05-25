<?php

declare(strict_types=1);

namespace App\Data\Decoder;

class DataDTO
{
    public function __construct(
        public bool $hasMinor,
        /** @var MonthDataDTO[] $monthDatas */
        public array $monthDatas = [],
    ) {}

    public function setMinor(): void {
        foreach ($this->monthDatas as $monthData) {
            foreach ($monthData->versions as $version) {
                if (count($version->minorVersions) > 0) {
                    $this->hasMinor = true;
                    return;
                }
            }
        }

        $this->hasMinor = false;
    }
}
