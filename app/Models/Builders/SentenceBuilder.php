<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\DataObjects\Sentences\Sentence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SentenceBuilder extends Builder
{
    public function createBySentence(int $durationId, Sentence $sentence): Model
    {
        return $this->create([
            'order' => $sentence->getOrder(),
            'sentence' => $sentence->getSentence(),
            'duration_id' => $durationId,
        ]);
    }
}
