<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\DataObjects\FilteredWords\FilteredWord;
use App\DataObjects\FilteredWords\FilteredWordCollection;

interface DefinitionsServiceInterface
{
    public function setDefinitionsToCollection(FilteredWordCollection $collection): FilteredWordCollection;

    public function setDefinitionsToWord(FilteredWord $word): FilteredWord;

    public function processDefinitionsByCollection(FilteredWordCollection $collection): FilteredWordCollection;
}
