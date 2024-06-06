<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Models\Duration;
use Illuminate\Database\Eloquent\Collection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, DurationDto>
 */
class DurationDtoCollection extends AbstractDtoCollection
{
    public function load(Collection $collection): AbstractDtoCollection
    {
        $this->items = [];
        $collection->each(fn (Duration $duration) => $this->add((new DurationDto())->load($duration)));

        return $this;
    }
}
