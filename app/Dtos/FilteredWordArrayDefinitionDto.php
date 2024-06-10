<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\Arrayable;

readonly class FilteredWordArrayDefinitionDto implements Arrayable
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
