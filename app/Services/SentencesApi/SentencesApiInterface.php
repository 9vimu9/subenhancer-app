<?php

declare(strict_types=1);

namespace App\Services\SentencesApi;

interface SentencesApiInterface
{
    /**
     * @template T of string
     *
     * @return array<int, T>
     */
    public function getSentences(string $caption): array;
}
