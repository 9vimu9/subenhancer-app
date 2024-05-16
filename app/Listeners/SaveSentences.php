<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\DurationSaved;
use App\Events\SentenceSaved;
use App\Services\SentenceServiceInterface;

class SaveSentences
{
    public function __construct(private SentenceServiceInterface $service)
    {
    }

    public function handle(DurationSaved $event): void
    {
        foreach ($this->service->captionToSentences($event->caption) as $sentence) {
            $sentenceModel = $this->service->storeSentence($event->durationId, $sentence);
            SentenceSaved::dispatch(
                $event->filteredWords,
                $sentence,
                $sentenceModel->getAttribute('id')
            );
        }
    }
}
