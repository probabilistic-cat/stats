<?php

declare(strict_types=1);

namespace App\DTO;

readonly class ContentViewDTO
{
    public function __construct(
        public string $categoryName,
        public string $categoryRoute,
        /** @var array<SubcategoryViewDTO> */
        public array $subcategories,
    ) {}
}
