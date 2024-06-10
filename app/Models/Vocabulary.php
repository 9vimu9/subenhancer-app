<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Contracts\Dtos\Dtoable;
use App\Dtos\VocabularydDto;
use App\Enums\VocabularyEnum;
use App\Models\Builders\VocabularyBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vocabulary extends Model implements Dtoable
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

    public function toDto(): VocabularydDto
    {
        return new VocabularydDto(
            $this->id,
            $this->user_id,
            $this->definition_id,
            VocabularyEnum::fromName($this->vocabulary_type)
        );
    }
}
