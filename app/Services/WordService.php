<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Apis\WordFilterApiInterface;
use App\Core\Contracts\Services\WordServiceInterface;
use App\DataObjects\Captions\CaptionsCollection;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Models\Corpus;

class WordService implements WordServiceInterface
{
    public function __construct(private WordFilterApiInterface $wordFilterApi)
    {
    }

    public function processWordsByCollection(CaptionsCollection $captionsCollection): FilteredWordCollection
    {
        Corpus::query()->storeByCollection(
            $filteredWordCollection = $this->wordFilterApi->filter($captionsCollection->toString())
        );

        return $filteredWordCollection;
    }
}
