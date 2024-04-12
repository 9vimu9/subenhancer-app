<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enhancement extends Model
{
    use HasFactory, SoftDeletes;

    public function vocabularies(): BelongsToMany
    {
        return $this->belongsToMany(Vocabulary::class);
    }
}