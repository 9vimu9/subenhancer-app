<?php

declare(strict_types=1);

namespace App\Core\Contracts\ResourceModels;

use App\Exceptions\UnresourcableModelProvidedException;
use App\Models\Source;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractResourceModel implements ResourceModelInterface
{
    public function saveToSource(?Model $resourceModel = null): Source
    {
        if (is_null($resourceModel)) {
            $resourceModel = $this->save();
        }
        if (! $resourceModel instanceof ResourcableInterface) {
            throw new UnresourcableModelProvidedException();
        }

        return $resourceModel
            ->source()
            ->create([]);
    }
}
