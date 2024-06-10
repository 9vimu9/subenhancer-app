<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\Arrayable;
use App\Core\Contracts\Dtos\Dto;

readonly class FilteredWordArrayDefinitionDto implements Arrayable, Dto
{
    public function __construct(
        public int $id,
        public int $corpusId,
        public string $definition,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'corpus_id' => $this->corpusId,
            'definition' => $this->definition,
        ];
    }
}
