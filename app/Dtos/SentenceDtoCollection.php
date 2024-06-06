<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Models\Sentence;
use Illuminate\Database\Eloquent\Collection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, SentenceDto>
 */
class SentenceDtoCollection extends AbstractDtoCollection
{
    public function load(Collection $collection): AbstractDtoCollection
    {
        $this->items = [];
        $collection->each(fn (Sentence $sentence) => $this->add((new SentenceDto())->load($sentence)));

        return $this;
    }
}
