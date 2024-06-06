<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\DtoInterface;
use App\Enums\VocabularyEnum;
use App\Models\Captionword;
use Illuminate\Database\Eloquent\Model;

class VocabularydDto implements DtoInterface
{
    public function __construct(
        public ?int $id = null,
        public ?int $userId = null,
        public ?int $definitionId = null,
        public ?VocabularyEnum $vocabularyType = null,
    ) {
    }

    public function toArray(): array
    {
        return
            [
                'id' => $this->id,
                'user_id' => $this->userId,
                'definition_id' => $this->definitionId,
                'vocabulary_type' => $this->vocabularyType->name,
            ];
    }

    public function load(Captionword|Model $model): DtoInterface
    {
        $this->id = $model->getAttributeOrNull('id');
        $this->userId = $model->getAttributeOrNull('user_id');
        $this->definitionId = $model->getAttributeOrNull('definition_id');
        $this->vocabularyType = ($vocabularyType = $model->getAttributeOrNull('vocabulary_type'))
            ? VocabularyEnum::fromName($vocabularyType) : null;

        return $this;
    }
}
