<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Corpus extends Model
{
    use HasFactory;

    public function definitions(): HasMany
    {
        return $this->hasMany(Definition::class);
    }
}
