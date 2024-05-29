<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\DataObjects\FilteredWords\FilteredWordCollection;

interface DefinitionsServiceInterface
{
    public function setDefinitionsToCollection(FilteredWordCollection $collection): FilteredWordCollection;

    public function processDefinitionsByCollection(FilteredWordCollection $collection): FilteredWordCollection;
}
