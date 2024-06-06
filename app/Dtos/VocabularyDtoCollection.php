<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Models\Vocabulary;
use Illuminate\Database\Eloquent\Collection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, SentenceDto>
 */
class VocabularyDtoCollection extends AbstractDtoCollection
{
    public function load(Collection $collection): AbstractDtoCollection
    {
        $this->items = [];
        $collection->each(fn (Vocabulary $vocabulary) => $this->add((new VocabularydDto())->load($vocabulary)));

        return $this;
    }
}
