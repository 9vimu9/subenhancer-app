<?php

declare(strict_types=1);

namespace App\DataObjects\FilteredWords;

use App\Core\Contracts\DataObjects\AbstractCollection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, FilteredWord>
 */
class FilteredWordCollection extends AbstractCollection
{
    public function toArrayOfWords(): array
    {
        $words = [];
        foreach ($this->items as $filteredWord) {
            $words[] = $filteredWord->getWord();
        }

        return $words;
    }
}
