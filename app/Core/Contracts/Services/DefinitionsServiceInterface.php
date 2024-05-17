<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\DataObjects\FilteredWords\FilteredWord;
use App\DataObjects\FilteredWords\FilteredWordCollection;

interface DefinitionsServiceInterface
{
    public function setDefinitionsToCollection(FilteredWordCollection $collection): FilteredWordCollection;

    public function setDefinitions(FilteredWord $word): FilteredWord;

    public function storeDefinitionsByCollection(FilteredWordCollection $collection): void;

    public function storeDefinitions(FilteredWord $filteredWord): void;
}
