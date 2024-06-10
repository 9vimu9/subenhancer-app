<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Core\Contracts\Services\VocabularyServiceInterface;
use App\Models\Vocabulary;

class VocabularyService implements VocabularyServiceInterface
{
    public function updateVocabularyBySource(int $sourceId, int $userId): void
    {
        Vocabulary::query()->updateVocabularyBySource($sourceId, $userId);
    }

    public function getVocabularyBySource(int $sourceId, int $userId): AbstractDtoCollection
    {
        return Vocabulary::query()->getUserVocabularyBySource($sourceId, $userId);
    }

    public function getUserVocabularyByEnhancement(string $enhancementUuid, int $userId): AbstractDtoCollection
    {
        return Vocabulary::query()->getVocabularyWithDefinitionByEnhancementUuid($enhancementUuid, $userId);
    }
}
