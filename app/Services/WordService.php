<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Corpus;
use App\Services\FilteredWords\FilteredWordCollection;
use Illuminate\Database\Eloquent\Model;

class WordService
{
    public function storeWord(string $word): Model
    {
        return Corpus::query()->saveWord($word);
    }

    public function storeWordsByCollection(FilteredWordCollection $filteredWordCollection): void
    {
        foreach ($filteredWordCollection->toArray() as $filteredWord) {
            $this->storeWord($filteredWord->getWord());
        }
    }
}
