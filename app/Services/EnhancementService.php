<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Resource\ResourceInterface;
use App\Core\Contracts\Services\CaptionServiceInterface;
use App\Core\Contracts\Services\DefinitionsServiceInterface;
use App\Core\Contracts\Services\EnhancementServiceInterface;
use App\Core\Contracts\Services\VocabularyServiceInterface;
use App\Core\Contracts\Services\WordServiceInterface;
use App\Dtos\EnhancementCreateDto;
use App\Events\ResourceProcessedEvent;
use App\Models\Corpus;
use App\Models\Enhancement;
use App\Models\Source;
use App\Models\User;

class EnhancementService implements EnhancementServiceInterface
{
    public function submitEnhancement(
        User $user,
        string $name,
        ResourceInterface $resource,
        DefinitionsServiceInterface $definitionsService,
        WordServiceInterface $wordService,
        CaptionServiceInterface $captionService,
        VocabularyServiceInterface $vocabularyService

    ): void {
        $sourceId = $resource->resourceModel()->resourceExists()
            ? $resource->resourceModel()->getSource()->getAttribute('id')
            : $this->createSource($resource, $wordService, $definitionsService, $captionService)->getAttribute('id');
        $enhancement = Enhancement::query()->createByUserId(
            new EnhancementCreateDto(name: $name, userId: $user->id, sourceId: $sourceId)
        );
        ResourceProcessedEvent::dispatch(
            $user->uuid,
            route('enhancement.create', [$enhancement->uuid]),
            $enhancement->name);
        $vocabularyService->updateVocabularyBySource($sourceId, $user->id);
        $definedWordsCollection = $vocabularyService->getVocabularyBySource($sourceId, $user->id);
    }

    private function createSource(
        ResourceInterface $resource,
        WordServiceInterface $wordService,
        DefinitionsServiceInterface $definitionsService,
        CaptionServiceInterface $captionService): Source
    {
        $source = $resource->resourceModel()->saveToSource();
        $captionsCollection = $resource->toCaptions();
        $filteredWordsCollection = $definitionsService->processDefinitionsByCollection(
            $wordService->processWordsByCollection($captionsCollection)
        );

        $captionService->processResource(
            $captionsCollection,
            $source->getAttribute('id'),
            Corpus::query()->filteredWordArrayToModels($filteredWordsCollection->toArrayOfWords())
        );

        return $source;
    }
}
