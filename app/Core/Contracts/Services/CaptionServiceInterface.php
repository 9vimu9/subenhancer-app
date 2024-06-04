<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\DataObjects\Captions\CaptionsCollection;
use App\Dtos\CorpusDtoCollection;

interface CaptionServiceInterface
{
    public function processResource(
        CaptionsCollection $captionsCollection,
        int $sourceId,
        CorpusDtoCollection $filteredWordsCorpusDtoCollection,
    ): void;
}
