<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Exceptions\WordNotInCorpusException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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

    public function wordsWithDefinitionsByFilteredWordCollection(
        FilteredWordCollection $filteredWordCollection,
        array $corpusColumns = ['id'],
        array $definitionColumns = ['id'],
    ): Collection {
        $definitionColumns[] = 'corpus_id';

        return $this->has('definitions')->with(['definitions' => function ($builder) use ($definitionColumns) {
            $builder->select($definitionColumns);
        }])->whereIn('word',
            $filteredWordCollection->toArrayOfWords()
        )->get($corpusColumns);
    }

    public function wordsWithoutDefinitionsByFilteredWordCollection(FilteredWordCollection $filteredWordCollection, array $columns = ['id']): Collection
    {
        return $this->whereDoesntHave('definitions')->whereIn('word',
            $filteredWordCollection->toArrayOfWords()
        )->get($columns);
    }
}
