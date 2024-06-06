<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Traits\Dtos\AttributeOrNullTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Definition extends Model
{
    use AttributeOrNullTrait,HasFactory;

    protected $fillable = ['corpus_id', 'definition', 'word_class'];

    public function corpus(): BelongsTo
    {
        return $this->belongsTo(Corpus::class);
    }

    public function captionwords(): HasMany
    {
        return $this->hasMany(Captionword::class);

    }
}
