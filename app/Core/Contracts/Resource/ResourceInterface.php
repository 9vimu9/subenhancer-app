<?php

declare(strict_types=1);

namespace App\Core\Contracts\Resource;

use App\Core\Contracts\ResourceModels\ResourceModelInterface;
use App\DataObjects\Captions\CaptionsCollection;

interface ResourceInterface
{
    public function toCaptions(): CaptionsCollection;

    public function resourceModel(): ResourceModelInterface;
}
