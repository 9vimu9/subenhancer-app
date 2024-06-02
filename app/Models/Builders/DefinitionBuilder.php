<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Core\Contracts\Apis\DefinitionsApiInterface;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Exceptions\CantFindDefinitionException;
use App\Exceptions\InvalidDefinitionResponseFormatException;
use App\Models\Corpus;
use Illuminate\Database\Eloquent\Builder;

class DefinitionBuilder extends Builder
{
    public function storeByCollection(FilteredWordCollection $collection, DefinitionsApiInterface $definitionsApi): void
    {
        $definitionsDataArray = [];
        Corpus::query()->wordsWithoutDefinitionsByFilteredWordCollection($collection, ['id', 'word'])
            ->each(function (Corpus $corpus) use (&$definitionsDataArray, $definitionsApi) {
                try {
                    $definitions = $definitionsApi->getDefinitions($corpus->word);
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
        $this->insertOrIgnore($definitionsDataArray);

    }
}
