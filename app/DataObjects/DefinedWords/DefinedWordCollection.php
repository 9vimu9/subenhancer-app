<?php

declare(strict_types=1);

namespace App\DataObjects\DefinedWords;

use App\Core\Contracts\DataObjects\AbstractCollection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, DefinedWord>
 */
class DefinedWordCollection extends AbstractCollection
{
}
