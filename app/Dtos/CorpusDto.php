<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\DtoInterface;

class CorpusDto implements DtoInterface
{
    public function __construct(
        public ?int $id,
        public ?string $word,
        public ?DefinitionDtoCollection $definitions,
    ) {
    }

    public function toArray(): array
    {
        $data = [
            'word' => $this->word,
            'definitions' => $this->definitions->toArray(),
        ];
        if (! is_null($this->id)) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
