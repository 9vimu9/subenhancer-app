<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Apis\DefinitionsApiInterface;
use App\Core\Contracts\Services\DefinitionsServiceInterface;
use App\DataObjects\Definitions\DefinitionCollection;
use App\DataObjects\FilteredWords\FilteredWord;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Exceptions\CantFindDefinitionException;
use App\Exceptions\InvalidDefinitionResponseFormatException;
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
                $collection->update($index, $this->setDefinitionsToWord($word));
            } catch (CantFindDefinitionException $exception) {
                Corpus::query()->removeByWord($word->getWord());
                $collection->remove($index);
            } catch (InvalidDefinitionResponseFormatException $exception) {
                continue;
            }
        }

        return $collection;
    }

    public function setDefinitionsToWord(FilteredWord $word): FilteredWord
    {
        $collection = new DefinitionCollection();
        $word->setDefinitions(
            $collection->loadByWord($word->getWord())
                ? $collection
                : $this->definitionsApi->getDefinitions($word->getWord())
        );

        return $word;
    }

    public function processDefinitionsByCollection(FilteredWordCollection $collection): FilteredWordCollection
    {
        Definition::query()->storeByCollection(
            $filteredWordCollection = $this->setDefinitionsToCollection($collection)
        );

        return $filteredWordCollection;
    }
}
