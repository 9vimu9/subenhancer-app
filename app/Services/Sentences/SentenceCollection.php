<?php

declare(strict_types=1);

namespace App\Services\Sentences;

class SentenceCollection
{
    /**
     * @template T of Sentence
     *
     * @var array<int, T>
     */
    private array $sentences;

    public function addSentence(Sentence $sentence): void
    {
        $this->sentences[] = $sentence;
    }

    /**
     * @template T of Sentence
     *
     * @return array<int, T>
     */
    public function toArray(): array
    {
        return $this->sentences;
    }
}
