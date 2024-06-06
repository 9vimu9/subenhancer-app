<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Core\Database\CustomBuilder;
use App\Dtos\VocabularydDto;
use App\Dtos\VocabularyDtoCollection;
use App\Enums\VocabularyEnum;
use App\Models\Captionword;
use App\Models\Vocabulary;
use Illuminate\Database\Eloquent\Builder;

class VocabularyBuilder extends CustomBuilder
{
    public function getUserVocabularyBySource(int $sourceId, int $userId): VocabularyDtoCollection
    {
        $vocabularies = Vocabulary::query()
            ->where('user_id', $userId)->whereHas('definition',
                function (Builder $definition) use ($sourceId) {
                    $definition->whereHas('captionwords',
                        function (Builder $captionwords) use ($sourceId) {
                            $captionwords->whereHas('sentence',
                                function (Builder $sentence) use ($sourceId) {
                                    $sentence->whereHas('duration',
                                        function (Builder $duration) use ($sourceId) {
                                            $duration->where('source_id', $sourceId);
                                        });
                                });
                        });
                })->get();

        return (new VocabularyDtoCollection())->load($vocabularies);

    }

    public function updateVocabularyBySource(int $sourceId, int $userId): void
    {

        $vocabularyDtoCollection = new VocabularyDtoCollection();
        Captionword::query()->getWordsBySourceId($sourceId, ['definition_id'])->each(function (Captionword $word) use ($userId, &$vocabularyDtoCollection) {
            $vocabularyDtoCollection->add(
                new VocabularydDto(userId: $userId, definitionId: $word->definition_id, vocabularyType: VocabularyEnum::HAVE_NOT_SPECIFIED)
            );
        });
        Vocabulary::query()->insertOrIgnore($vocabularyDtoCollection->toArray());
    }
}
