<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\Arrayable;
use App\Core\Contracts\Dtos\Dto;
use App\Enums\VocabularyEnum;

readonly class CreateVocabularydDto implements Arrayable, Dto
{
    public function __construct(
        public int $userId,
        public int $definitionId,
        public VocabularyEnum $vocabularyType,
    ) {
    }

    public function toArray(): array
    {
        return
            [
                'user_id' => $this->userId,
                'definition_id' => $this->definitionId,
                'vocabulary_type' => $this->vocabularyType->name,
            ];
    }
}
