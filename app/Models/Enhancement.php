<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Builders\EnhancementBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enhancement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'uuid', 'source_id', 'name', 'description'];

    public function vocabularies(): BelongsToMany
    {
        return $this->belongsToMany(Vocabulary::class);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new EnhancementBuilder($query);
    }
}
