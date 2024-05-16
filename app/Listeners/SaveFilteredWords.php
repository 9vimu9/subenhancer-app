<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\SentenceSaved;
use App\Services\FilteredWordServiceInterface;

class SaveFilteredWords
{
    public function __construct(private FilteredWordServiceInterface $service)
    {
    }

    public function handle(SentenceSaved $event): void
    {
        $this->service->saveFilteredWordWhichFoundInSentence(
            $event->filteredWords,
            $event->sentence,
            $event->sentenceId);
    }
}
