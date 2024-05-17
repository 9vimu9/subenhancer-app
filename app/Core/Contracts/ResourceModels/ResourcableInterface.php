<?php

declare(strict_types=1);

namespace App\Core\Contracts\ResourceModels;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface ResourcableInterface
{
    public function source(): MorphOne;
}
