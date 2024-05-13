<?php

declare(strict_types=1);

namespace App\Services\Sentences;

use App\Core\AbstractCollection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, Sentence>
 */
class SentenceCollection extends AbstractCollection
{
    public function add(Sentence $sentence): void
    {
        $this->items[] = $sentence;
    }
}
