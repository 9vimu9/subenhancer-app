<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Resource\ResourceInterface;
use App\Core\Contracts\Services\CaptionServiceInterface;
use App\Core\Contracts\Services\DefinitionsServiceInterface;
use App\Core\Contracts\Services\EnhancementServiceInterface;
use App\Core\Contracts\Services\VocabularyServiceInterface;
use App\Core\Contracts\Services\WordServiceInterface;
use App\Models\Enhancement;
use App\Models\Source;

class EnhancementService implements EnhancementServiceInterface
{
    public function submitEnhancement(
        ResourceInterface $resource,
        DefinitionsServiceInterface $definitionsService,
        WordServiceInterface $wordService,
        CaptionServiceInterface $captionService,
        VocabularyServiceInterface $vocabularyService

    ): void {
        $sourceId = $resource->resourceModel()->resourceExists()
            ? $resource->resourceModel()->getSource()->getAttribute('id')
            : $this->createSource($resource, $wordService, $definitionsService, $captionService)->getAttribute('id');
        $enhancement = Enhancement::query()->createByUserId(auth()->id(), $sourceId);
        $vocabularyService->updateVocabularyBySource($sourceId);
        $definedWordsCollection = $vocabularyService->getVocabularyBySource($sourceId);
    }

    private function createSource(ResourceInterface $resource,
        WordServiceInterface $wordService,
        DefinitionsServiceInterface $definitionsService,
        CaptionServiceInterface $captionService): Source
    {
        $source = $resource->resourceModel()->saveToSource();
        $captionsCollection = $resource->toCaptions();
        $filteredWordCollection = $definitionsService->processDefinitionsByCollection(
            $wordService->processWordsByCollection($captionsCollection)
        );
        $captionService->saveDurationsByCollection(
            $captionsCollection,
            $source->getAttribute('id'),
            $filteredWordCollection->toArrayOfWords(),
        );

        return $source;
    }
}
