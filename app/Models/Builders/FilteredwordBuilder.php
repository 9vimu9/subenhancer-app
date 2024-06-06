<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Core\Database\CustomBuilder;
use App\Models\Captionword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class FilteredwordBuilder extends CustomBuilder
{
    public function getWordsBySourceId(int $sourceId, array $columns = ['*']): Collection
    {
        return Captionword::query()
            ->whereHas('sentence',
                function (Builder $sentence) use ($sourceId) {
                    $sentence->whereHas('duration',
                        function (Builder $duration) use ($sourceId) {
                            $duration->where('source_id', $sourceId);
                        });
                })->get($columns);

    }
}
