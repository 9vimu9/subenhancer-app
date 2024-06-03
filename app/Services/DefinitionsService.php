<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Apis\DefinitionsApiInterface;
use App\Core\Contracts\Services\DefinitionsServiceInterface;
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

    public function removeWordsHasNoDefinitionsFromCollection(FilteredWordCollection $collection): FilteredWordCollection
    {
        $newCollection = new FilteredWordCollection();

        Corpus::query()->wordsWithDefinitionsByFilteredWordCollection(
            filteredWordCollection: $collection,
            corpusColumns: ['id', 'word'],
            definitionColumns: ['id', 'word_class', 'definition']
        )->each(function (Corpus $corpus) use (&$newCollection) {
            $word = new FilteredWord($corpus->word);
            $newCollection->add($word);
        });

        return $newCollection;
    }

    public function processDefinitionsByCollection(FilteredWordCollection $collection): FilteredWordCollection
    {
        Definition::query()->insertOrIgnore(
            $this->findDefinitionsForWordsWhichHasNot($collection)
        );

        return $this->removeWordsHasNoDefinitionsFromCollection($collection);
    }

    public function findDefinitionsForWordsWhichHasNot(FilteredWordCollection $collection): array
    {
        $definitionsDataArray = [];
        Corpus::query()->wordsWithoutDefinitionsByFilteredWordCollection($collection, ['id', 'word'])
            ->each(function (Corpus $corpus) use (&$definitionsDataArray) {
                try {
                    $definitions = $this->definitionsApi->getDefinitions($corpus->word);
                } catch (InvalidDefinitionResponseFormatException|CantFindDefinitionException $exception) {
                    return true;
                }
                foreach ($definitions as $definition) {
                    $definitionsDataArray[] = [
                        'corpus_id' => $corpus->id,
                        'definition' => $definition->getDefinition(),
                        'word_class' => $definition->getWordClass()->name,
                    ];
                }
            });

        return $definitionsDataArray;
    }
}
