<?php

declare(strict_types=1);

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class DefinitionBuilder extends Builder
{
    public function storeByCollection(array $definitionsDataArray): void
    {
        $this->insertOrIgnore($definitionsDataArray);

    }
}
