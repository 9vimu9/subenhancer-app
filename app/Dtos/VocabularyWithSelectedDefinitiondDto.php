<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\Arrayable;
use App\Enums\VocabularyEnum;

readonly class VocabularyWithSelectedDefinitiondDto implements Arrayable
{
    public function __construct(
        public int $id,
        public int $userId,
        public VocabularyEnum $vocabularyType,
        public DefinitionDto $definition,
    ) {
    }

    public function toArray(): array
    {
        return
            [
                'id' => $this->id,
                'user_id' => $this->userId,
                'vocabulary_type' => $this->vocabularyType->name,
                'definition' => $this->definition->toArray(),
            ];
    }
}
