<?php

declare(strict_types=1);

namespace App\Core\Contracts\Dtos;

use App\Core\Contracts\DataObjects\AbstractCollection;
use App\Exceptions\NotADtoItemIncludedToTheCollectionException;

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
}
