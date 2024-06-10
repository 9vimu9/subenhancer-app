<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\Dto;

readonly class EnhancementCreateDto implements Dto
{
    public function __construct(
        public string $name,
        public int $userId,
        public int $sourceId,
    ) {
    }
}
