<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Apis\DefinitionsApiInterface;
use App\Core\Contracts\Services\DefinitionsServiceInterface;
use App\DataObjects\FilteredWords\FilteredWord;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Exceptions\CantFindDefinitionException;
use App\Exceptions\DefinitionAlreadyExistException;
use App\Exceptions\WordNotInCorpusException;
use App\Models\Corpus;
use App\Models\Definition;

class DefinitionsService implements DefinitionsServiceInterface
{
    public function __construct(private DefinitionsApiInterface $definitionsApi)
    {
    }

    public function setDefinitionsToCollection(FilteredWordCollection $collection): FilteredWordCollection
    {
        foreach ($collection as $index => $word) {
            try {
                $collection->update($index, $this->setDefinitions($word));
            } catch (CantFindDefinitionException $exception) {
                $collection->remove($index);
            }
        }

        return $collection;
    }

    public function setDefinitions(FilteredWord $word): FilteredWord
    {
        $word->setDefinitions($this->definitionsApi->getDefinitions($word->getWord()));

        return $word;
    }

    public function storeDefinitionsByCollection(FilteredWordCollection $collection): void
    {
        foreach ($collection as $word) {
            try {
                $this->storeDefinitions($word);
            } catch (DefinitionAlreadyExistException|WordNotInCorpusException $exception) {
                continue;
            }
        }
    }

    public function storeDefinitions(FilteredWord $filteredWord): void
    {
        $word = Corpus::query()->findByWordOrFail($filteredWord->getWord());

        if ($word->definitions()->count()) {
            throw new DefinitionAlreadyExistException();
        }

        foreach ($filteredWord->getDefinitions() as $definition) {
            Definition::query()->createByDefinition($word->id, $definition);

        }
    }

    public function processDefinitionsByCollection(FilteredWordCollection $collection): FilteredWordCollection
    {
        $this->storeDefinitionsByCollection(
            $filteredWordCollection = $this->setDefinitionsToCollection($collection)
        );

        return $filteredWordCollection;
    }
}
