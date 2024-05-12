<?php

declare(strict_types=1);

namespace App\Models\ResourceModels;

use App\Exceptions\TryingToStoreRecordForNonPolymorphicallyRelatedTableException;
use App\Models\Source;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractResourceModel implements ResourceModelInterface
{
    public function saveToSource(?Model $resourceModel = null): Source
    {
        if (is_null($resourceModel)) {
            $resourceModel = $this->save();
        }
        if (! method_exists($resourceModel, 'source')) {
            throw new TryingToStoreRecordForNonPolymorphicallyRelatedTableException();
        }

        return $resourceModel
            ->source()
            ->create([]);
    }
}
