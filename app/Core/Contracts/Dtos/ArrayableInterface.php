<?php

declare(strict_types=1);

namespace App\Core\Contracts\Dtos;

interface ArrayableInterface
{
    public function toArray(): array;
}