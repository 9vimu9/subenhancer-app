<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\Arrayable;

readonly class CorpusDto implements Arrayable
{
    public function __construct(
        public int $id,
        public string $word,
        public DefinitionDtoCollection $definitions,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'word' => $this->word,
            'definitions' => $this->definitions->toArray(),
        ];
    }
}
