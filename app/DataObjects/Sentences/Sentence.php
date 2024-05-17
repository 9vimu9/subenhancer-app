<?php

declare(strict_types=1);

namespace App\DataObjects\Sentences;

class Sentence
{
    public function __construct(
        private string $sentence,
        private int $order = 0
    ) {
    }

    public function getSentence(): string
    {
        return $this->sentence;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): void
    {
        $this->order = $order;
    }
}
