<?php

declare(strict_types=1);

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class CorpusBuilder extends Builder
{
    public function hasWord(string $word): bool
    {
        return $this->where('word', $word)->exists();
    }
}
