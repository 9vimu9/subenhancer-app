<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Core\Contracts\Dtos\Arrayable;
use App\Core\Contracts\Dtos\Dto;

readonly class CorpusDto implements Arrayable, Dto
{
    public function __construct(
        public int $id,
        public string $word,
        public AbstractDtoCollection $definitions,
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
