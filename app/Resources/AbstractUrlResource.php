<?php

declare(strict_types=1);

namespace App\Resources;

use App\Models\ResourceModels\ResourceModelInterface;

abstract class AbstractUrlResource implements ResourceInterface
{
    public function resourceModel(): ResourceModelInterface
    {
        return $this->resourceModel;
    }
}
