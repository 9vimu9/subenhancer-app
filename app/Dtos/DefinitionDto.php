<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\Arrayable;
use App\Enums\WordClassEnum;

readonly class DefinitionDto implements Arrayable
{
    public function __construct(
        public int $id,
        public int $corpusId,
        public string $definition,
        public WordClassEnum $wordClass,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'corpus_id' => $this->corpusId,
            'definition' => $this->definition,
            'word_class' => $this->wordClass->name,
        ];
    }
}
