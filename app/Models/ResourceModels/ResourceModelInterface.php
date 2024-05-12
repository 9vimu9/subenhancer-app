<?php

declare(strict_types=1);

namespace App\Models\ResourceModels;

use App\Models\Source;

interface ResourceModelInterface
{
    public function resourceExists(): bool;

    public function saveToSource(): Source;
}
