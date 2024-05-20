<?php

declare(strict_types=1);

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class FilteredwordBuilder extends Builder
{
    public function updateDefinition(int $filterWordId, int $definitionId): void
    {
        $this->findOrFail($filterWordId)->update(['definition_id' => $definitionId]);

    }
}
