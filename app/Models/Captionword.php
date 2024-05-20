<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Builders\FilteredwordBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Captionword extends Model
{
    protected $fillable = ['order_in_sentence', 'sentence_id', 'definition_id'];

    use HasFactory;

    public function newEloquentBuilder($query): Builder
    {
        return new FilteredwordBuilder($query);
    }

    public function sentence(): BelongsTo
    {
        return $this->belongsTo(Sentence::class);
    }
}
