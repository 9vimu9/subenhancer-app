<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Captions\Caption;
use App\Services\Captions\CaptionsCollection;
use Illuminate\Database\Eloquent\Model;

interface CaptionSetviceInterface
{
    public function captionHasFilteredWord(Caption $caption, array $arryOfWords): bool;

    public function saveDuration(int $sourceId, Caption $caption): Model;

    public function saveDurationsByCollection(
        CaptionsCollection $captionsCollection,
        int $sourceId,
        array $filteredWords,
    ): void;
}
