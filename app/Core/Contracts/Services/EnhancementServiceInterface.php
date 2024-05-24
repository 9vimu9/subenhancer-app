<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\Core\Contracts\Resource\ResourceInterface;
use App\Services\CaptionService;
use App\Services\DefinitionsService;
use App\Services\WordService;

interface EnhancementServiceInterface
{
    public function submitEnhancement(
        ResourceInterface $resource,
        DefinitionsService $definitionsService,
        WordService $wordService,
        CaptionService $captionService,
        VocabularyServiceInterface $vocabularyService

    ): void;
}
