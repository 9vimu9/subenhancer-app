<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Core\Contracts\Services\DefinitionSelectorServiceInterface;
use App\Events\NewFilteredWordsStored;

class UpdateDefiniton
{
    public function __construct(private DefinitionSelectorServiceInterface $definitionSelectorService)
    {
    }

    public function handle(NewFilteredWordsStored $event): void
    {
        $this->definitionSelectorService->updateFilteredWordDefinition(
            $event->filteredwordId,
            $event->sentence,
            $event->corpusId,
            $event->order
        );

    }
}
