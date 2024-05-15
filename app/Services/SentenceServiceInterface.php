<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Captions\Caption;
use App\Services\Sentences\Sentence;
use App\Services\Sentences\SentenceCollection;
use Illuminate\Database\Eloquent\Model;

interface SentenceServiceInterface
{
    public function captionToSentences(Caption $caption): SentenceCollection;

    public function storeSentence(int $durationId, Sentence $sentence): Model;
}
