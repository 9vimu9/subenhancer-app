<?php

declare(strict_types=1);

namespace App\Events;

use App\DataObjects\Sentences\Sentence;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SentenceSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    //  SaveFilteredWords
    public function __construct(
        public array $filteredWords,
        public Sentence $sentence,
        public int $sentenceId
    ) {
    }
}
