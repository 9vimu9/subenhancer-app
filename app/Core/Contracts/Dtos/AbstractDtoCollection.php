<?php

declare(strict_types=1);

namespace App\Core\Contracts\Dtos;

use App\Core\Contracts\DataObjects\AbstractCollection;
use App\Exceptions\NotADtoItemIncludedToTheCollectionException;
use Illuminate\Database\Eloquent\Collection;

abstract class AbstractDtoCollection extends AbstractCollection implements Arrayable
{
    public function toArray(): array
    {
        $items = [];
        foreach ($this->items as $item) {

            if (! $item instanceof Arrayable) {
                throw new NotADtoItemIncludedToTheCollectionException($this, $item);
            }
            $items[] = $item->toArray();
        }

        return $items;
    }

    public function loadFromEloquentCollection(Collection $collection, ?callable $callback = null): AbstractDtoCollection
    {
        $callback = $callback ?? static fn (Dtoable $model) => $model;
        $this->items = [];
        $collection->each(function (Dtoable $model) use ($callback) {
            $this->add($callback($model));
        });

        return $this;
    }
}
