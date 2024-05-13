<?php

declare(strict_types=1);

namespace App\Services\FilteredWords;

class FilteredWordCollection
{
    /**
     * @template T of FilteredWord
     *
     * @var array<int, T>
     */
    private array $filteredWords = [];

    public function addFilteredWord(FilteredWord $filteredWord): void
    {
        $this->filteredWords[] = $filteredWord;
    }

    /**
     * @template T of FilteredWord
     *
     * @return array<int, T>
     */
    public function toArray(): array
    {
        return $this->filteredWords;
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
