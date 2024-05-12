<?php

declare(strict_types=1);

namespace App\Models\ResourceModels;

use App\Models\Source;
use Illuminate\Database\Eloquent\Model;

interface ResourceModelInterface
{
    public function resourceExists(): bool;

    public function saveToSource(?Model $resourceModel = null): Source;

    public function save(): Model;
}
