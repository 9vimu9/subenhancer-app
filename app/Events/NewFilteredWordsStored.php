<?php

declare(strict_types=1);

namespace App\Events;

use App\DataObjects\Sentences\Sentence;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewFilteredWordsStored
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $filteredwordId,
        public Sentence $sentence,
        public int $sentenceId,
        public int $corpusId,
        public int $order,

    ) {
    }
}
