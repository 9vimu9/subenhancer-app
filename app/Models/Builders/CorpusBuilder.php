<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Exceptions\WordNotInCorpusException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CorpusBuilder extends Builder
{
    public function findByWordOrFail(string $word, array $columns = ['id']): Model
    {
        return $this->findByWord($word, $columns) ?: throw new WordNotInCorpusException();
    }

    public function findByWord(string $word, array $columns = ['id']): ?Model
    {
        return $this->where('word', strtolower($word))->first($columns);
    }

    public function removeByWord(string $word): void
    {
        if (is_null($corpus = $this->findByWord($word))) {
            return;
        }
        $corpus->delete();
    }

    public function storeByCollection(FilteredWordCollection $filteredWordCollection): void
    {
        $processedInputs = [];
        foreach ($filteredWordCollection as $word) {
            $processedInputs[] = ['word' => $word->getWord()];
        }
        $this->insertOrIgnore($processedInputs);
    }
}
