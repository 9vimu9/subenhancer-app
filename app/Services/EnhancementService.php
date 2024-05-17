<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Enhancement;
use App\Resources\ResourceInterface;

class EnhancementService implements EnhancementServiceInterface
{
    public function submitEnhancement(
        ResourceInterface $resource,
        DefinitionsServiceInterface $definitionsService,
        WordServiceInterface $wordService,
        CaptionServiceInterface $captionService,

    ): void {
        $enhancement = Enhancement::query()->createByUserId(auth()->id());
        if (! $resource->resourceModel()->resourceExists()) {
            $source = $this->createSource($resource, $wordService, $definitionsService, $captionService);
        }
        $source = $source ?? $resource->resourceModel()->getSource();
        Enhancement::query()->updateSourceId(
            $enhancement->getAttribute('id'),
            $source->getAttribute('id'));
    }

    public function createSource(ResourceInterface $resource, WordServiceInterface $wordService, DefinitionsServiceInterface $definitionsService, CaptionServiceInterface $captionService): \App\Models\Source
    {
        $source = $resource->resourceModel()->saveToSource();
        $captionsCollection = $resource->toCaptions();
        $filteredWordCollection = $wordService->filterWordsByCollection($captionsCollection);
        $wordService->storeWordsByCollection($filteredWordCollection);
        $filteredWordCollection = $definitionsService->setDefinitionsToCollection($filteredWordCollection);
        $definitionsService->storeDefinitionsByCollection($filteredWordCollection);
        $captionService->saveDurationsByCollection(
            $captionsCollection,
            $source->getAttribute('id'),
            $filteredWordCollection->toArrayOfWords(),
        );

        return $source;
    }
}
