<?php

declare(strict_types=1);

namespace App\Dtos;

readonly class EnhancementCreateDto
{
    public function __construct(
        public string $name,
        public int $userId,
        public int $sourceId,
    ) {
    }
}
