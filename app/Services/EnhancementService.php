<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Resource\ResourceInterface;
use App\Core\Contracts\Services\CaptionServiceInterface;
use App\Core\Contracts\Services\DefinitionSelectorServiceInterface;
use App\Core\Contracts\Services\DefinitionsServiceInterface;
use App\Core\Contracts\Services\EnhancementServiceInterface;
use App\Core\Contracts\Services\SentenceServiceInterface;
use App\Core\Contracts\Services\VocabularyServiceInterface;
use App\Core\Contracts\Services\WordServiceInterface;
use App\Models\Enhancement;
use App\Models\Source;

class EnhancementService implements EnhancementServiceInterface
{
    public function submitEnhancement(
        DefinitionSelectorServiceInterface $definitionSelectorService,
        SentenceServiceInterface $sentenceService,
        ResourceInterface $resource,
        DefinitionsServiceInterface $definitionsService,
        WordServiceInterface $wordService,
        CaptionServiceInterface $captionService,
        VocabularyServiceInterface $vocabularyService

    ): void {
        $sourceId = $resource->resourceModel()->resourceExists()
            ? $resource->resourceModel()->getSource()->getAttribute('id')
            : $this->createSource($definitionSelectorService, $sentenceService, $resource, $wordService, $definitionsService, $captionService)->getAttribute('id');
        $enhancement = Enhancement::query()->createByUserId(auth()->id(), $sourceId);
        $vocabularyService->updateVocabularyBySource($sourceId);
        $definedWordsCollection = $vocabularyService->getVocabularyBySource($sourceId);
    }

    private function createSource(
        DefinitionSelectorServiceInterface $definitionSelectorService,
        SentenceServiceInterface $sentenceService,
        ResourceInterface $resource,
        WordServiceInterface $wordService,
        DefinitionsServiceInterface $definitionsService,
        CaptionServiceInterface $captionService): Source
    {
        $source = $resource->resourceModel()->saveToSource();
        $captionsCollection = $resource->toCaptions();
        $captionService->processResource(
            $definitionSelectorService,
            $sentenceService,
            $captionsCollection,
            $source->getAttribute('id'),
            $definitionsService->processDefinitionsByCollection(
                $wordService->processWordsByCollection($captionsCollection)
            )->toArrayOfWords()
        );

        return $source;
    }
}
