<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\DurationSaved;
use App\Models\Duration;
use App\Services\Captions\Caption;
use App\Services\Captions\CaptionsCollection;
use App\Traits\StringArrayOperationsTrait;
use Illuminate\Database\Eloquent\Model;

class CaptionService implements CaptionServiceInterface
{
    use StringArrayOperationsTrait;

    private function saveDuration(int $sourceId, Caption $caption): Model
    {
        return Duration::query()->create([
            'start_time_in_millis' => $caption->getStartTime(),
            'end_time_in_millis' => $caption->getEndTime(),
            'source_id' => $sourceId,
        ]);

    }

    public function saveDurationsByCollection(
        CaptionsCollection $captionsCollection,
        int $sourceId,
        array $filteredWords,
    ): void {
        foreach ($captionsCollection as $caption) {
            $captionWordArray = $this->stringToCleansedWordArray($caption->getCaption());
            if (! count($this->getIntersectionOfWordArrays($captionWordArray, $filteredWords))) {
                continue;
            }
            $duration = $this->saveDuration($sourceId, $caption);
            DurationSaved::dispatch(
                $filteredWords,
                $duration->getAttribute('id'),
                $caption);
        }
    }
}
