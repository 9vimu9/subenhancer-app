<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database\CustomBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Duration extends Model
{
    use HasFactory;

    protected $fillable = ['start_time_in_millis', 'end_time_in_millis', 'source_id'];

    public function sentences(): HasMany
    {
        return $this->hasMany(Sentence::class);
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new class($query) extends CustomBuilder
        {
        };
    }
}
