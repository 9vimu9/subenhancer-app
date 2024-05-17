<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Builders\CorpusBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Corpus extends Model
{
    use HasFactory;

    protected $fillable = ['word'];

    public function definitions(): HasMany
    {
        return $this->hasMany(Definition::class);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new CorpusBuilder($query);
    }
}
