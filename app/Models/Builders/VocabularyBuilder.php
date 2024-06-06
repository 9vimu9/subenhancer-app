<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Models\Vocabulary;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class VocabularyBuilder extends Builder
{
    public function getUserVocabularyBySource(int $sourceId, int $userId): Collection
    {
        return Vocabulary::query()
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

    }
}
