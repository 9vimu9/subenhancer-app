<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Apis\SentencesApiInterface;
use App\DataObjects\Captions\Caption;
use App\DataObjects\Sentences\SentenceCollection;
use App\Models\Sentence;
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

    public function storeSentence(int $durationId, \App\DataObjects\Sentences\Sentence $sentence): Model
    {
        return Sentence::query()->createBySentence($durationId, $sentence);
    }
}
