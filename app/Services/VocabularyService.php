<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Services\VocabularyServiceInterface;
use App\Dtos\VocabularyDtoCollection;
use App\Models\Vocabulary;

class VocabularyService implements VocabularyServiceInterface
{
    public function updateVocabularyBySource(int $sourceId): void
    {
        $userId = auth()->id();
        Vocabulary::query()->updateVocabularyBySource($sourceId, $userId);
    }

    public function getVocabularyBySource(int $sourceId): VocabularyDtoCollection
    {
        return Vocabulary::query()->getUserVocabularyBySource($sourceId, auth()->id());
    }
}
