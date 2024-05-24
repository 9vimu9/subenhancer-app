<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Services\VocabularyServiceInterface;
use App\Enums\VocabularyEnum;
use App\Models\Captionword;
use App\Models\Vocabulary;

class VocabularyService implements VocabularyServiceInterface
{
    public function updateVocabularyBySource(int $sourceId): void
    {
        $userId = auth()->id();
        Captionword::query()->getWordsBySourceId($sourceId)->each(function (Captionword $word) use ($userId) {
            $definitionId = $word->getAttribute('definition_id');
            if (! Vocabulary::query()->alreadyIncludedForTheUser($definitionId, $userId)) {
                Vocabulary::query()->store(VocabularyEnum::HAVE_NOT_SPECIFIED, $definitionId, $userId);
            }
        });

    }
}
