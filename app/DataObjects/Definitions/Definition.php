<?php

declare(strict_types=1);

namespace App\DataObjects\Definitions;

use App\Enums\WordClassEnum;

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
}
