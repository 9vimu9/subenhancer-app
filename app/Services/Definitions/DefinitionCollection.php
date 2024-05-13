<?php

declare(strict_types=1);

namespace App\Services\Definitions;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, Definition>
 */
class DefinitionCollection implements IteratorAggregate
{
    /** @var Definition[] */
    private array $definitions = [];

    public function add(Definition $definition): void
    {
        $this->definitions[] = $definition;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->definitions);
    }
}
