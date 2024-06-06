<?php

declare(strict_types=1);

namespace App\Core\Contracts\Dtos;

use Illuminate\Database\Eloquent\Collection;

interface LoadByCollectionInterface
{
    public function load(Collection $collection): AbstractDtoCollection;
}
