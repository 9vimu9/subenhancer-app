<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vocabulary extends Model
{
    use HasFactory;

    public function Enhancements(): BelongsToMany
    {
        return $this->belongsToMany(Enhancement::class);
    }
}
