<?php

declare(strict_types=1);

namespace App\Services\SentencesApi;

use App\DataObjects\Sentences\SentenceCollection;

interface SentencesApiInterface
{
    public function getSentences(string $caption): SentenceCollection;
}
