<?php

declare(strict_types=1);

namespace App\Resources;

interface ResourceInterface
{
    public function isAlreadyExist(): bool;
}
