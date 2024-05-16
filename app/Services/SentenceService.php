<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Sentence;
use App\Services\Captions\Caption;
use App\Services\Sentences\SentenceCollection;
use App\Services\SentencesApi\SentencesApiInterface;
use Illuminate\Database\Eloquent\Model;

class SentenceService implements SentenceServiceInterface
{
    public function __construct(private SentencesApiInterface $sentencesApi)
    {
    }

    public function captionToSentences(Caption $caption): SentenceCollection
    {
        return $this->sentencesApi->getSentences($caption->getCaption());
    }

    public function storeSentence(int $durationId, \App\Services\Sentences\Sentence $sentence): Model
    {
        return Sentence::query()->createBySentence($durationId, $sentence);
    }
}
