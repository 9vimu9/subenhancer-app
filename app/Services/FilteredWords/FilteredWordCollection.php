<?php

declare(strict_types=1);

namespace App\Services\FilteredWords;

use App\Exceptions\CantFindDefinitionException;
use App\Exceptions\DefinitionAlreadyExistException;
use App\Services\DefinitionsAPI\DefinitionsApiInterface;

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

    public function storeNewFilteredWordsDefinitions(DefinitionsApiInterface $definitionsApi): void
    {
        foreach ($this->filteredWords as $index => $filteredWord) {
            try {
                $filteredWord->storeDefinitions($definitionsApi);
            } catch (DefinitionAlreadyExistException $exception) {
                continue;

            } catch (CantFindDefinitionException $exception) {
                unset($this->filteredWords[$index]);

                continue;
            }
        }

    }
}
