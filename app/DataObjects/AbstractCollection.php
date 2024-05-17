<?php

declare(strict_types=1);

namespace App\DataObjects;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

abstract class AbstractCollection implements IteratorAggregate
{
    protected array $items = [];

    public function __construct(...$items)
    {
        $this->items = $items;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
