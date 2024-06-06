<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Builders\VocabularyBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vocabulary extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'definition_id', 'vocabulary_type'];

    public function newEloquentBuilder($query): Builder
    {
        return new VocabularyBuilder($query);
    }

    public function definition(): BelongsTo
    {
        return $this->belongsTo(Definition::class);
    }
}
