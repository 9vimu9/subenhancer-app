<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Core\Database\CustomBuilder;
use App\Dtos\CreateVocabularydDto;
use App\Dtos\DtoCollection;
use App\Enums\VocabularyEnum;
use App\Models\Captionword;
use App\Models\Vocabulary;
use Illuminate\Database\Eloquent\Builder;

class VocabularyBuilder extends CustomBuilder
{
    public function getUserVocabularyBySource(int $sourceId, int $userId): AbstractDtoCollection
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

        return (new DtoCollection())->loadFromEloquentCollection($vocabularies);

    }

    public function updateVocabularyBySource(int $sourceId, int $userId): void
    {

        $vocabularyDtoCollection = new DtoCollection();
        Captionword::query()->getWordsBySourceId($sourceId, ['definition_id'])->each(function (Captionword $word) use ($userId, &$vocabularyDtoCollection) {
            $vocabularyDtoCollection->add(
                new CreateVocabularydDto(userId: $userId, definitionId: $word->definition_id, vocabularyType: VocabularyEnum::HAVE_NOT_SPECIFIED)
            );
        });
        Vocabulary::query()->insertOrIgnore($vocabularyDtoCollection->toArray());
    }
}
