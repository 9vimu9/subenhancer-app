<?php

declare(strict_types=1);

namespace App\Core\Contracts\Dtos;

interface DtoInterface
{
    public function toArray(): array;
}
