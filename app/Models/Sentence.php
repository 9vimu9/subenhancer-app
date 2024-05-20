<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Builders\SentenceBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sentence extends Model
{
    protected $fillable = ['order', 'sentence', 'duration_id'];

    use HasFactory;

    public function newEloquentBuilder($query): Builder
    {
        return new SentenceBuilder($query);
    }

    public function filteredwords(): HasMany
    {
        return $this->hasMany(Captionword::class);
    }

    public function duration(): BelongsTo
    {
        return $this->belongsTo(Duration::class);

    }
}
