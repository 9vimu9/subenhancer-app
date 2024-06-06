<?php

declare(strict_types=1);

namespace App\Core\Contracts\Dtos;

use Illuminate\Database\Eloquent\Model;

interface LoadByModelInterface
{
    public function load(Model $model): DtoInterface;
}
