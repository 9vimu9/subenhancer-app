<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\DataObjects\Captions\CaptionsCollection;

interface CaptionServiceInterface
{
    public function processResource(
        CaptionsCollection $captionsCollection,
        int $sourceId,
        AbstractDtoCollection $filteredWordsCorpusDtoCollection,
    ): void;
}
