<?php

declare(strict_types=1);

namespace App\Resources;

use App\Core\Contracts\ResourceModels\ResourceModelInterface;

abstract class AbstractResource implements ResourceInterface
{
    protected ResourceModelInterface $resourceModel;

    public function resourceModel(): ResourceModelInterface
    {
        return $this->resourceModel;
    }
}
