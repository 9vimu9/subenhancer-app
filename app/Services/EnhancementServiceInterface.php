<?php

declare(strict_types=1);

namespace App\Services;

use App\Resources\ResourceInterface;
use Illuminate\Database\Eloquent\Model;

interface EnhancementServiceInterface
{
    public function create(int $userId): Model;

    public function updateSourceId(int $enhancementId, int $sourceId): void;

    public function submitEnhancement(
        ResourceInterface $resource,
        DefinitionsService $definitionsService,
        WordService $wordService,
        CaptionService $captionService,

    ): void;
}
