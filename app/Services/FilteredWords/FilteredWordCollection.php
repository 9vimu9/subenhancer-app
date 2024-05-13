<?php

declare(strict_types=1);

namespace App\Services\FilteredWords;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, FilteredWord>
 */
class FilteredWordCollection implements IteratorAggregate
{
    /** @var FilteredWord[] */
    private array $filteredWords = [];

    public function add(FilteredWord $filteredWord): void
    {
        $this->filteredWords[] = $filteredWord;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->filteredWords);
    }

    public function toArrayOfWords(): array
    {
        $words = [];
        foreach ($this->filteredWords as $filteredWord) {
            $words[] = $filteredWord->getWord();
        }

        return $words;
    }
}
