<?php

declare(strict_types=1);

namespace App\Services\FilteredWords;

use App\Core\AbstractCollection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, FilteredWord>
 */
class FilteredWordCollection extends AbstractCollection
{
    public function add(FilteredWord $filteredWord): void
    {
        $this->items[] = $filteredWord;
    }

    public function toArrayOfWords(): array
    {
        $words = [];
        foreach ($this->items as $filteredWord) {
            $words[] = $filteredWord->getWord();
        }

        return $words;
    }
}
