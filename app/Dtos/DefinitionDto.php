<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\DtoInterface;
use App\Enums\WordClassEnum;

class DefinitionDto implements DtoInterface
{
    public function __construct(
        public ?int $id,
        public ?int $corpusId,
        public ?string $definition,
        public WordClassEnum $wordClass,
    ) {
    }

    public function toArray(): array
    {
        $data = [
            'corpus_id' => $this->corpusId,
            'definition' => $this->definition,
            'word_class' => $this->wordClass->name,
        ];
        if (! is_null($this->id)) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
