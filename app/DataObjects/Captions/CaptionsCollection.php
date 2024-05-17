<?php

declare(strict_types=1);

namespace App\DataObjects\Captions;

use App\Core\Contracts\DataObjects\AbstractCollection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, Caption>
 */
class CaptionsCollection extends AbstractCollection
{
    public function toString(): string
    {
        $captionsStrings = [];
        foreach ($this->items as $caption) {
            $captionsStrings[] = $caption->getCaption();
        }

        return trim(implode(' ', $captionsStrings));
    }
}
