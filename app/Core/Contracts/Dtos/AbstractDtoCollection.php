<?php

declare(strict_types=1);

namespace App\Core\Contracts\Dtos;

use App\Core\Contracts\Collections\Collection;
use App\Core\Contracts\Collections\GenericCollection;
use App\Exceptions\NonArrayableDtoFoundException;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractDtoCollection implements AddableDto, Arrayable, Collection
{
    protected array $items = [];

    use GenericCollection;

    public function __construct(...$items)
    {
        $this->addItems($items);
    }

    public function toArray(): array
    {
        $items = [];
        foreach ($this->items as $item) {

            if (! $item instanceof Arrayable) {
                throw new NonArrayableDtoFoundException($this, $item);
            }
            $items[] = $item->toArray();
        }

        return $items;
    }

    public function loadFromEloquentCollection(EloquentCollection $collection, ?callable $callback = null): AbstractDtoCollection
    {
        $this->items = [];
        $collection->each(
            is_null($callback) ? fn (Dtoable $model) => $this->add($model->toDto())
                : fn (Model $model) => $this->add($callback($model))
        );

        return $this;
    }

    public function add(Dto $dto): void
    {
        $this->items[] = $dto;
    }
}
