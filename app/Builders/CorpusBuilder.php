<?php

declare(strict_types=1);

namespace App\Builders;

use App\Exceptions\WordInCorpusException;
use App\Exceptions\WordNotInCorpusException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CorpusBuilder extends Builder
{
    public function findByWordOrFail(string $word): Model
    {
        return $this->findByWord($word) ?: throw new WordNotInCorpusException();
    }

    public function findByWord(string $word): ?Model
    {
        return $this->where('word', $word)->first();
    }

    public function saveWord(string $word): Model
    {
        return $this->findByWord($word) ? throw new WordInCorpusException() : $this->create(['word' => $word]);
    }
}
