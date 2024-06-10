<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Models\Definition;
use Illuminate\Database\Eloquent\Collection;

class FilteredWordArrayDefinitionDtoCollection extends DefinitionDtoCollection
{
    public function loadFromEloquentCollection(Collection $collection): AbstractDtoCollection
    {
        $this->items = [];
        $collection->each(fn (Definition $model) => $this->add(
            new FilteredWordArrayDefinitionDto(
                id: $model->id,
                corpusId: $model->corpus_id,
                definition: $model->definition
            )
        ));

        return $this;
    }
}
