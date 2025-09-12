<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enum\DataFileResultStatus;

readonly class DataFileResultDTO
{
    public function __construct(
        public DataFileResultStatus $status,
        public string $filePath,
        public string $message,
        public ?string $fileUrl = null,
    ) {}
}
