<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Source extends Model
{
    use HasFactory;

    public function sourceable(): MorphTo
    {
        return $this->morphTo();
    }
}
