<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\SentenceBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
    protected $fillable = ['order', 'sentence', 'duration_id'];

    use HasFactory;

    public function newEloquentBuilder($query): Builder
    {
        return new SentenceBuilder($query);
    }
}
