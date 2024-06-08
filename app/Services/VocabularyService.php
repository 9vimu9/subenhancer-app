<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Services\VocabularyServiceInterface;
use App\Dtos\VocabularyDtoCollection;
use App\Models\Enhancement;
use App\Models\Vocabulary;

class VocabularyService implements VocabularyServiceInterface
{
    public function updateVocabularyBySource(int $sourceId, int $userId): void
    {
        Vocabulary::query()->updateVocabularyBySource($sourceId, $userId);
    }

    public function getVocabularyBySource(int $sourceId, int $userId): VocabularyDtoCollection
    {
        return Vocabulary::query()->getUserVocabularyBySource($sourceId, $userId);
    }

    public function getUserVocabularyByEnhancement(string $enhancementUuid, int $userId): VocabularyDtoCollection
    {
        return $this->getVocabularyBySource(
            Enhancement::query()->where('uuid', $enhancementUuid)->firstOrFail()->source_id,
            $userId);
    }
}
