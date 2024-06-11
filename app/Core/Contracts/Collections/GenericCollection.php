<?php

declare(strict_types=1);

namespace App\Core\Contracts\Collections;

use ArrayIterator;
use OutOfBoundsException;
use Traversable;

trait GenericCollection
{
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

    public function items(): array
    {
        return $this->items;
    }

    public function addItems(array $items): void
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }
}
