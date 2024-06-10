<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Contracts\Dtos\Dtoable;
use App\Dtos\CorpusDto;
use App\Dtos\DefinitionDtoCollection;
use App\Models\Builders\CorpusBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Corpus extends Model implements Dtoable
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

    public function toDto(): CorpusDto
    {

        return new CorpusDto(
            $this->id,
            $this->word,
            (new DefinitionDtoCollection())->loadFromEloquentCollection($corpus->definitions ?? $this->definitions()->get())
        );
    }
}
