<?php

declare(strict_types=1);

namespace App\Core\Contracts\Collections;

use IteratorAggregate;

interface Collection extends IteratorAggregate
{
    public function remove(int $index): void;

    public function update(int $index, mixed $item): void;

    public function count(): int;

    public function get(int $index): mixed;

    public function items(): array;

    public function addItems(array $items): void;
}
