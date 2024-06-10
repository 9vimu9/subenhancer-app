<?php

declare(strict_types=1);

namespace App\Core\Contracts\Dtos;

use App\Core\Contracts\DataObjects\AbstractCollection;
use App\Exceptions\NonArrayableDtoFoundException;
use App\Exceptions\NotADtoException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractDtoCollection extends AbstractCollection implements Arrayable
{
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

    public function loadFromEloquentCollection(Collection $collection, ?callable $callback = null): AbstractDtoCollection
    {
        $this->items = [];
        $callback = is_null($callback) ? fn (Dtoable $model) => $this->add($model->toDto())
            : function (Model $model) use ($callback) {
                $dto = $callback($model);
                if (! $dto instanceof Dto) {
                    throw new NotADtoException($dto);
                }
                $this->add($dto);
            };
        $collection->each($callback);

        return $this;
    }
}
