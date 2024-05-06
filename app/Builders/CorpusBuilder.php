<?php

declare(strict_types=1);

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CorpusBuilder extends Builder
{
    public function hasWord(string $word): bool
    {
        return $this->where('word', $word)->exists();
    }

    public function findByWord(string $word): Model
    {
        return $this->where('word', $word)->firstOrFail();
    }

    public function saveWord(string $word): Model
    {
        return $this->create(['word' => $word]);
    }
}
