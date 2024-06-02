<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\DataObjects\Captions\CaptionsCollection;

interface CaptionServiceInterface
{
    public function processResource(
        DefinitionSelectorServiceInterface $definitionSelectorService,
        SentenceServiceInterface $sentenceService,
        CaptionsCollection $captionsCollection,
        int $sourceId,
        array $filteredWords,
    ): void;
}
