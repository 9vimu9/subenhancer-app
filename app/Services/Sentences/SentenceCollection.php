<?php

declare(strict_types=1);

namespace App\Services\Sentences;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, Sentence>
 */
class SentenceCollection implements IteratorAggregate
{
    /** @var Sentence[] */
    private array $sentences;

    public function add(Sentence $sentence): void
    {
        $this->sentences[] = $sentence;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->sentences);
    }
}
