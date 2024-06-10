<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\Arrayable;
use App\Core\Contracts\Dtos\Dto;

readonly class CaptionwordDto implements Arrayable, Dto
{
    public function __construct(
        public int $id,
        public int $order,
        public int $sentenceId,
        public int $definitionId
    ) {
    }

    public function toArray(): array
    {
        return
            [
                'id' => $this->id,
                'order_in_sentence' => $this->order,
                'sentence_id' => $this->sentenceId,
                'definition_id' => $this->definitionId,
            ];
    }
}
