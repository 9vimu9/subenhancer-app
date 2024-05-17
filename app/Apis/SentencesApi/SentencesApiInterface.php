<?php

declare(strict_types=1);

namespace App\Apis\SentencesApi;

use App\DataObjects\Sentences\SentenceCollection;

interface SentencesApiInterface
{
    public function getSentences(string $caption): SentenceCollection;
}
