<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Source extends Model
{
    use HasFactory;

    public function sourceable(): MorphTo
    {
        return $this->morphTo();
    }

    public function durations(): HasMany
    {
        return $this->hasMany(Duration::class);
    }

    public function enhancements(): HasMany
    {
        return $this->hasMany(Enhancement::class);
    }
}
