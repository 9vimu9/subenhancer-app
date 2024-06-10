<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Contracts\Dtos\Dtoable;
use App\Dtos\DefinitionDto;
use App\Enums\WordClassEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Definition extends Model implements Dtoable
{
    use HasFactory;

    protected $fillable = ['corpus_id', 'definition', 'word_class'];

    public function corpus(): BelongsTo
    {
        return $this->belongsTo(Corpus::class);
    }

    public function captionwords(): HasMany
    {
        return $this->hasMany(Captionword::class);

    }

    public function toDto(): DefinitionDto
    {
        return new DefinitionDto(
            $this->id,
            $this->corpus_id,
            $this->definition,
            WordClassEnum::fromName($this->word_class),
        );
    }
}
