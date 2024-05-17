<?php

declare(strict_types=1);

namespace App\Services;

use App\Apis\WordsFilterApi\WordFilterApiInterface;
use App\DataObjects\Captions\CaptionsCollection;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Exceptions\WordInCorpusException;
use App\Models\Corpus;

class WordService implements WordServiceInterface
{
    public function __construct(private WordFilterApiInterface $wordFilterApi)
    {
    }

    public function storeWordsByCollection(FilteredWordCollection $filteredWordCollection): void
    {
        foreach ($filteredWordCollection as $filteredWord) {
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
