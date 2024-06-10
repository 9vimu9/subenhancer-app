<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\Arrayable;
use App\Core\Contracts\Dtos\Dto;
use App\Enums\WordClassEnum;

readonly class CreateDefinitionDto implements Arrayable, Dto
{
    public function __construct(
        public int $corpusId,
        public string $definition,
        public WordClassEnum $wordClass,
    ) {
    }

    public function toArray(): array
    {
        return [
            'corpus_id' => $this->corpusId,
            'definition' => $this->definition,
            'word_class' => $this->wordClass->name,
        ];
    }
}
