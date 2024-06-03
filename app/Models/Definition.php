<?php

declare(strict_types=1);

namespace App\Models;

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
}
