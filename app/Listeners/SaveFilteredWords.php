<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Core\Contracts\Services\FilteredWordServiceInterface;
use App\Events\SentenceSaved;

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
