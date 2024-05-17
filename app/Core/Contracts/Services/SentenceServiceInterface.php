<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\DataObjects\Captions\Caption;
use App\DataObjects\Sentences\Sentence;
use App\DataObjects\Sentences\SentenceCollection;
use Illuminate\Database\Eloquent\Model;

interface SentenceServiceInterface
{
    public function captionToSentences(Caption $caption): SentenceCollection;

    public function storeSentence(int $durationId, Sentence $sentence): Model;
}
