<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Services\VocabularyServiceInterface;
use App\Enums\VocabularyEnum;
use App\Models\Captionword;
use App\Models\Vocabulary;
use Illuminate\Database\Eloquent\Collection;

class VocabularyService implements VocabularyServiceInterface
{
    public function updateVocabularyBySource(int $sourceId): void
    {
        $userId = auth()->id();
        $vocabularyDataArray = [];
        Captionword::query()->getWordsBySourceId($sourceId, ['definition_id'])->each(function (Captionword $word) use ($userId, &$vocabularyDataArray) {
            $definitionId = $word->getAttribute('definition_id');
            $vocabularyDataArray[] = ['definition_id' => $definitionId, 'user_id' => $userId, 'vocabulary_type' => VocabularyEnum::HAVE_NOT_SPECIFIED->name];
        });
        Vocabulary::query()->insertOrIgnore($vocabularyDataArray);

    }

    public function getVocabularyBySource(int $sourceId): Collection
    {
        return Vocabulary::query()->getUserVocabularyBySource($sourceId, auth()->id());
    }
}
