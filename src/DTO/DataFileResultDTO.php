<?php

declare(strict_types=1);

namespace App\DTO;

enum DataFileResultStatus
{
    case SUCCESS;
    case FAILED;
}

readonly class DataFileResultDTO
{
    public function __construct(
        public DataFileResultStatus $status,
        public string $filePath,
        public string $message,
        public ?string $fileUrl = null,
    ) {}
}
