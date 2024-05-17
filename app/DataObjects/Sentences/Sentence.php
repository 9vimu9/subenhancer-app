<?php

declare(strict_types=1);

namespace App\DataObjects\Sentences;

class Sentence
{
    private string $sentence;

    public function getSentence(): string
    {
        return $this->sentence;
    }

    private int $order;

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setSentence(string $sentence): void
    {
        $this->sentence = $sentence;
    }

    public function setOrder(int $order): void
    {
        $this->order = $order;
    }
}
