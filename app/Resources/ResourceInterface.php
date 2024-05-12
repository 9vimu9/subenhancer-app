<?php

declare(strict_types=1);

namespace App\Resources;

use App\Models\ResourceModels\ResourceModelInterface;
use App\Services\Captions\CaptionsCollection;

interface ResourceInterface
{
    public function toCaptions(): CaptionsCollection;

    public function resourceModel(): ResourceModelInterface;
}
