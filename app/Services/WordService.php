<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\WordInCorpusException;
use App\Models\Corpus;
use App\Services\Captions\CaptionsCollection;
use App\Services\FilteredWords\FilteredWordCollection;
use App\Services\WordsFilterApi\WordFilterApiInterface;

class WordService
{
    public function __construct(private WordFilterApiInterface $wordFilterApi)
    {
    }

    public function storeWordsByCollection(FilteredWordCollection $filteredWordCollection): void
    {
        foreach ($filteredWordCollection->toArray() as $filteredWord) {
            try {
                Corpus::query()->saveWord($filteredWord->getWord());
            } catch (WordInCorpusException $exception) {
                continue;
            }
        }
    }

    public function filterWordsByCollection(CaptionsCollection $captionsCollection): FilteredWordCollection
    {
        return $this->wordFilterApi->filter($captionsCollection->toString());
    }
}
