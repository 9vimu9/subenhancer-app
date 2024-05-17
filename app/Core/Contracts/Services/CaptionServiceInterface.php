<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\DataObjects\Captions\CaptionsCollection;

interface CaptionServiceInterface
{
    public function saveDurationsByCollection(
        CaptionsCollection $captionsCollection,
        int $sourceId,
        array $filteredWords,
    ): void;
}
