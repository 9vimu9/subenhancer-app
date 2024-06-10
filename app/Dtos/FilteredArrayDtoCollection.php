<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Models\Corpus;
use Illuminate\Database\Eloquent\Collection;

class FilteredArrayDtoCollection extends AbstractDtoCollection
{
    public function loadFromEloquentCollection(Collection $collection): AbstractDtoCollection
    {
        $this->items = [];
        $collection->each(fn (Corpus $corpus) => $this->add(
            new CorpusDto(
                id: $corpus->id,
                word: $corpus->word,
                definitions: (new FilteredWordArrayDefinitionDtoCollection())->loadFromEloquentCollection($corpus->definitions),
            )
        ));

        return $this;
    }
}
