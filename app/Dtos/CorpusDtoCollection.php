<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Models\Corpus;
use Illuminate\Database\Eloquent\Collection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, CorpusDto>
 */
class CorpusDtoCollection extends AbstractDtoCollection
{
    public function load(Collection $collection): AbstractDtoCollection
    {
        $this->items = [];
        $collection->each(fn (Corpus $corpus) => $this->add((new CorpusDto())->load($corpus)));

        return $this;
    }
}
