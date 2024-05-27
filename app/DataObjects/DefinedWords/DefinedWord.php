<?php

declare(strict_types=1);

namespace App\DataObjects\DefinedWords;

use App\Models\Captionword;
use App\Models\Corpus;
use App\Models\Definition;

class DefinedWord
{
    public function __construct(private Captionword $captionword)
    {
    }

    public function getDefinition(): string
    {
        return $this->getDefinitionModel()->getAttribute('definition');
    }

    public function getWord(): string
    {
        return $this->getCorpus()->getAttribute('word');
    }

    public function getDefinitionId(): int
    {
        return $this->captionword->getAttribute('definition_id');
    }

    public function getCorpusId(): int
    {
        return $this->getCorpus()->getAttribute('id');
    }

    private function getCorpus(): Corpus
    {
        return $this->getDefinitionModel()->corpus()->first();
    }

    private function getDefinitionModel(): Definition
    {
        return $this->captionword->definition()->first();
    }
}
