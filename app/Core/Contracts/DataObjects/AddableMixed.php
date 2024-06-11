<?php

declare(strict_types=1);

namespace App\Core\Contracts\DataObjects;

interface AddableMixed
{
    public function add(mixed $item): void;
}
