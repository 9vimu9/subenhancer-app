<?php

declare(strict_types=1);

namespace App\Core\Contracts\Dtos;

interface Arrayable
{
    public function toArray(): array;
}
