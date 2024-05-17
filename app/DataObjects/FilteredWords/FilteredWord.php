<?php

declare(strict_types=1);

namespace App\DataObjects\FilteredWords;

use App\DataObjects\Definitions\DefinitionCollection;
use App\Exceptions\DefinitionsHasNotBeenDefinedException;

class FilteredWord
{
    private DefinitionCollection $definitions;

    public function __construct(private string $word)
    {
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getDefinitions(): DefinitionCollection
    {
        if (! isset($this->definitions)) {
            throw new DefinitionsHasNotBeenDefinedException();
        }

        return $this->definitions;
    }

    public function setDefinitions(DefinitionCollection $definitions): void
    {
        $this->definitions = $definitions;
    }
}
