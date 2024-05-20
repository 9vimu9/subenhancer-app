<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\DataObjects\Sentences\Sentence;

interface DefinitionSelectorServiceInterface
{
    public function updateFilteredWordDefinition(
        int $filteredWordId,
        Sentence $sentence,
        int $corpusId,
        int $orderInTheSentence): void;
}
