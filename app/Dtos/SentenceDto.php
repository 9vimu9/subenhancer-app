<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\Arrayable;
use App\Core\Contracts\Dtos\Dto;

readonly class SentenceDto implements Arrayable, Dto
{
    public function __construct(
        public int $id,
        public int $order,
        public string $sentence,
        public int $durationId
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'order' => $this->order,
            'sentence' => $this->sentence,
            'duration_id' => $this->durationId,
        ];
    }
}
