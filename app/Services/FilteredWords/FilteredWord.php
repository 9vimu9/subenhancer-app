<?php

declare(strict_types=1);

namespace App\Services\FilteredWords;

use App\Exceptions\DefinitionAlreadyExistException;
use App\Models\Corpus;
use App\Services\Definitions\DefinitionCollection;
use App\Services\DefinitionsAPI\DefinitionsApiInterface;

class FilteredWord
{
    public function __construct(private string $word)
    {
    }

    public function isNewWord(): bool
    {
        return ! Corpus::query()->hasWord($this->word);

    }

    public function getDefinitions(DefinitionsApiInterface $definitionsApi): DefinitionCollection
    {
        return $definitionsApi->getDefinitions($this->word);
    }

    public function storeDefinitions(DefinitionsApiInterface $definitionsApi): void
    {
        if (! $this->isNewWord()) {
            throw new DefinitionAlreadyExistException();
        }
        $definitions = $this->getDefinitions($definitionsApi)->toArray();
        $corpus = Corpus::query()->saveWord($this->word);
        foreach ($definitions as $definition) {
            $definition->store((int) $corpus->id);
        }

    }
}
