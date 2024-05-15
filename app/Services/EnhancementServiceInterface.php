<?php

declare(strict_types=1);

namespace App\Services;

use App\Resources\ResourceInterface;

interface EnhancementServiceInterface
{
    public function submitEnhancement(
        ResourceInterface $resource,
        DefinitionsService $definitionsService,
        WordService $wordService,
        CaptionService $captionService,

    ): void;
}
