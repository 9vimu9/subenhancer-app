<?php

declare(strict_types=1);

namespace App\Resources;

use App\DataObjects\Captions\CaptionsCollection;
use App\Models\ResourceModels\ResourceModelInterface;

interface ResourceInterface
{
    public function toCaptions(): CaptionsCollection;

    public function resourceModel(): ResourceModelInterface;
}
