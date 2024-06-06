<?php

declare(strict_types=1);

namespace App\Core\Traits\Dtos;

use Illuminate\Database\Eloquent\Model;
use RuntimeException;

trait AttributeOrNullTrait
{
    public function getAttributeOrNull(string $key): mixed
    {
        if (! $this instanceof Model) {
            throw new RuntimeException();
        }

        return $this->hasAttribute($key) ? $this->{$key} : null;
    }
}
