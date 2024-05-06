<?php

declare(strict_types=1);

namespace App\Services\Definitions;

use App\Enums\WordClassEnum;
use App\Models\Corpus;
use Illuminate\Database\Eloquent\Model;

class Definition
{
    public function __construct(
        private WordClassEnum $wordClass,
        private string $definition,
        private string $word
    ) {
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getWordClass(): WordClassEnum
    {
        return $this->wordClass;
    }

    public function getDefinition(): string
    {
        return $this->definition;
    }

    public function store(): Model
    {
        $corpus = Corpus::query()->findByWord($this->word);

        return \App\Models\Definition::query()->create([
            'corpus_id' => $corpus->id,
            'definition' => $this->definition,
            'word_class' => $this->wordClass->value,
        ]);
    }
}
