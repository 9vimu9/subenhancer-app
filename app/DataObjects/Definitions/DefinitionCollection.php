<?php

declare(strict_types=1);

namespace App\DataObjects\Definitions;

use App\Core\Contracts\DataObjects\AbstractCollection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, Definition>
 */
class DefinitionCollection extends AbstractCollection
{
}
