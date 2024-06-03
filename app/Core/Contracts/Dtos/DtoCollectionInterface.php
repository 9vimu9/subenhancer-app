<?php

declare(strict_types=1);

namespace App\Core\Contracts\Dtos;

interface DtoCollectionInterface
{
    public function toArray(): array;
}
