<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\CantFindDefinitionException;
use App\Exceptions\DefinitionAlreadyExistException;
use App\Models\Corpus;
use App\Models\Definition;
use App\Services\DefinitionsAPI\DefinitionsApiInterface;
use App\Services\FilteredWords\FilteredWord;
use App\Services\FilteredWords\FilteredWordCollection;

readonly class DefinitionsService
{
    public function __construct(private DefinitionsApiInterface $definitionsApi)
    {
    }

    public function setDefinitionsToCollection(FilteredWordCollection $collection): FilteredWordCollection
    {
        $updatedCollection = new FilteredWordCollection();
        foreach ($collection->toArray() as $word) {
            try {
                $updatedCollection->addFilteredWord($this->setDefinitions($word));
            } catch (CantFindDefinitionException $exception) {
                continue;
            }
        }

        return $updatedCollection;
    }

    public function setDefinitions(FilteredWord $word): FilteredWord
    {
        $word->setDefinitions($this->definitionsApi->getDefinitions($word->getWord()));

        return $word;
    }

    public function storeDefinitionsByCollection(FilteredWordCollection $collection): void
    {
        foreach ($collection->toArray() as $word) {
            $this->storeDefinitions($word);
        }
    }

    public function storeDefinitions(FilteredWord $filteredWord): void
    {
        if (Definition::query()->findDefinitionsByWord($filteredWord->getWord())->count()) {
            throw new DefinitionAlreadyExistException();
        }

        $word = Corpus::query()->findByWord($filteredWord->getWord());
        foreach ($filteredWord->getDefinitions()->toArray() as $definition) {
            Definition::query()->createByDefinition($word->id, $definition);

        }
    }
}
