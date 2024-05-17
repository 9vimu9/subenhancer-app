<?php

declare(strict_types=1);

namespace App\DataObjects\Definitions;

use App\DataObjects\AbstractCollection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, Definition>
 */
class DefinitionCollection extends AbstractCollection
{
    public function add(Definition $definition): void
    {
        $this->items[] = $definition;
    }
}
