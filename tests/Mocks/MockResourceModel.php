<?php

declare(strict_types=1);

namespace Tests\Mocks;

use App\Models\ResourceModels\AbstractResourceModel;
use Illuminate\Database\Eloquent\Model;

class MockResourceModel extends AbstractResourceModel
{
    public function resourceExists(): bool
    {
        return true;
    }

    public function save(): Model
    {
        return new class extends Model
        {
        };
    }

    public function getSource(): Model
    {
        return new class extends Model
        {
        };
    }
}
