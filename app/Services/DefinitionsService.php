<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Apis\DefinitionsApiInterface;
use App\Core\Contracts\Services\DefinitionsServiceInterface;
use App\DataObjects\Definitions\DefinitionCollection;
use App\DataObjects\FilteredWords\FilteredWord;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Enums\WordClassEnum;
use App\Models\Corpus;
use App\Models\Definition;

class DefinitionsService implements DefinitionsServiceInterface
{
    public function __construct(private DefinitionsApiInterface $definitionsApi)
    {
    }

    public function setDefinitionsToCollection(FilteredWordCollection $collection): FilteredWordCollection
    {
        $newCollection = new FilteredWordCollection();

        Corpus::query()->wordsWithDefinitionsByFilteredWordCollection(
            filteredWordCollection: $collection,
            corpusColumns: ['id', 'word'],
            definitionColumns: ['id', 'word_class', 'definition']
        )->each(function (Corpus $corpus) use (&$newCollection) {
            $definitionCollection = new DefinitionCollection();
            $corpus->definitions->each(function (Definition $definition) use (&$definitionCollection, $corpus) {
                $definitionCollection->add(
                    new \App\DataObjects\Definitions\Definition(
                        WordClassEnum::fromName($definition->word_class),
                        $definition->definition,
                        $corpus->word
                    )
                );
            });
            $word = new FilteredWord($corpus->word);
            $word->setDefinitions($definitionCollection);
            $newCollection->add($word);
        });

        return $newCollection;
    }

    public function processDefinitionsByCollection(FilteredWordCollection $collection): FilteredWordCollection
    {
        Definition::query()->storeByCollection($collection, $this->definitionsApi);

        return $this->setDefinitionsToCollection($collection);
    }
}
