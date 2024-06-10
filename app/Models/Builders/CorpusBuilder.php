<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Core\Database\CustomBuilder;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Dtos\CorpusDto;
use App\Dtos\DtoCollection;
use App\Dtos\FilteredWordArrayDefinitionDtoCollection;
use App\Models\Corpus;
use Illuminate\Database\Eloquent\Collection;

class CorpusBuilder extends CustomBuilder
{
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

    public function filteredWordArrayToModels(array $filteredWords): AbstractDtoCollection
    {
        return (new DtoCollection())->loadFromEloquentCollection(
            $this->with('definitions:id,definition,corpus_id')
                ->whereIn('word', $filteredWords)
                ->select(['word', 'id'])->get(), function (Corpus $corpus) {
                    return new CorpusDto(
                        id: $corpus->id,
                        word: $corpus->word,
                        definitions: (new FilteredWordArrayDefinitionDtoCollection())->loadFromEloquentCollection($corpus->definitions),
                    );
                });
    }
}
