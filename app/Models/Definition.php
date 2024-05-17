<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Builders\DefinitionBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Definition extends Model
{
    use HasFactory;

    protected $fillable = ['corpus_id', 'definition', 'word_class'];

    public function corpus(): BelongsTo
    {
        return $this->belongsTo(Corpus::class);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new DefinitionBuilder($query);
    }
}
