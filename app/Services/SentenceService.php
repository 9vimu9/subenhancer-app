<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Apis\SentencesApiInterface;
use App\Core\Contracts\Services\SentenceServiceInterface;
use App\DataObjects\Captions\Caption;
use App\DataObjects\Sentences\SentenceCollection;

class SentenceService implements SentenceServiceInterface
{
    public function __construct(private SentencesApiInterface $sentencesApi)
    {
    }

    public function captionToSentences(Caption $caption): SentenceCollection
    {
        return $this->sentencesApi->getSentences($caption->getCaption());
    }
}
