<?php

declare(strict_types=1);

namespace App\DataObjects\DefinedWords;

use App\Exceptions\IncompatibleVocabularyAndCaptionwordProvidedException;
use App\Models\Captionword;
use App\Models\Corpus;
use App\Models\Definition;
use App\Models\Vocabulary;

class DefinedWord
{
    public function __construct(private Vocabulary $vocabulary, private Captionword $captionword)
    {
        $this->validateParams();
    }

    private function validateParams(): void
    {
        if ($this->vocabulary->getAttribute('definition_id') !== $this->captionword->getAttribute('definition_id')) {
            throw new IncompatibleVocabularyAndCaptionwordProvidedException();
        }
    }

    public function getDefinition(): string
    {
        return $this->getDefinitionModel()
            ->getAttribute('definition');
    }

    public function getWord(): string
    {
        return $this->getCorpus()->getAttribute('word');
    }

    public function getDefinitionId(): int
    {
        return $this->vocabulary->getAttribute('definition_id');
    }

    public function getCorpusId(): int
    {
        return $this->getCorpus()->getAttribute('id');
    }

    private function getCorpus(): Corpus
    {
        return $this->getDefinitionModel()
            ->corpus()
            ->first();
    }

    private function getDefinitionModel(): Definition
    {
        return $this->captionword
            ->definition()
            ->first();
    }
}
