<?php

declare(strict_types=1);

namespace App\Core\Contracts\DataObjects;

use ArrayIterator;
use IteratorAggregate;
use OutOfBoundsException;
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

    public function remove(int $index): void
    {
        if (! array_key_exists($index, $this->items)) {
            throw new OutOfBoundsException();
        }
        unset($this->items[$index]);
    }

    public function update(int $index, mixed $item): void
    {
        if (! array_key_exists($index, $this->items)) {
            throw new OutOfBoundsException();
        }
        $this->items[$index] = $item;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function get(int $index): mixed
    {
        if (! array_key_exists($index, $this->items)) {
            throw new OutOfBoundsException();
        }

        return $this->items[$index];
    }

    public function add(mixed $item): void
    {
        $this->items[] = $item;
    }

    public function items(): array
    {
        return $this->items;
    }
}
