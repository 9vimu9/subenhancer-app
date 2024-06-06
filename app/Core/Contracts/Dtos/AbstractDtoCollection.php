<?php

declare(strict_types=1);

namespace App\Core\Contracts\Dtos;

use App\Core\Contracts\DataObjects\AbstractCollection;
use App\Exceptions\NotADtoItemIncludedToTheCollectionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractDtoCollection extends AbstractCollection implements DtoCollectionInterface
{
    public function toArray(): array
    {
        $items = [];
        foreach ($this->items as $item) {

            if (! $item instanceof DtoInterface) {
                throw new NotADtoItemIncludedToTheCollectionException($this, $item);
            }
            $items[] = $item->toArray();
        }

        return $items;
    }

    public function load(Collection $collection): AbstractDtoCollection
    {
        $this->items = [];
        $collection->each(fn (Model $model) => $this->add($this->itemDto()->load($model)));

        return $this;
    }
}
