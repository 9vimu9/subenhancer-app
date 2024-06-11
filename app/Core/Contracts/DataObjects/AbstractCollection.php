<?php

declare(strict_types=1);

namespace App\Core\Contracts\DataObjects;

use App\Core\Contracts\Collections\Collection;
use App\Core\Contracts\Collections\GenericCollection;

abstract class AbstractCollection implements AddableMixed, Collection
{
    use GenericCollection;

    protected array $items = [];

    public function __construct(...$items)
    {
        $this->items = $items;
    }

    public function add(mixed $item): void
    {
        $this->items[] = $item;
    }
}
