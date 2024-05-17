<?php

declare(strict_types=1);

namespace App\Events;

use App\DataObjects\Captions\Caption;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DurationSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    //SaveSentences
    public function __construct(
        public array $filteredWords,
        public int $durationId,
        public Caption $caption)
    {
    }
}
