<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\DataObjects\Captions\Caption;
use App\DataObjects\Sentences\SentenceCollection;

interface SentenceServiceInterface
{
    public function captionToSentences(Caption $caption): SentenceCollection;
}
