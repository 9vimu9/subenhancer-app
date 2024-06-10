<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\Core\Contracts\Dtos\AbstractDtoCollection;

interface VocabularyServiceInterface
{
    public function updateVocabularyBySource(int $sourceId, int $userId);

    public function getVocabularyBySource(int $sourceId, int $userId): AbstractDtoCollection;

    public function getUserVocabularyByEnhancement(string $enhancementUuid, int $userId): AbstractDtoCollection;
}
