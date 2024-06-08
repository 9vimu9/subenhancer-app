<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\Dtos\VocabularyDtoCollection;

interface VocabularyServiceInterface
{
    public function updateVocabularyBySource(int $sourceId, int $userId);

    public function getVocabularyBySource(int $sourceId, int $userId): VocabularyDtoCollection;

    public function getUserVocabularyByEnhancement(string $enhancementUuid, int $userId): VocabularyDtoCollection;
}
