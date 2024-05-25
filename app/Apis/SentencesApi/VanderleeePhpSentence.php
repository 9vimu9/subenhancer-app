<?php

declare(strict_types=1);

namespace App\Apis\SentencesApi;

use App\Core\Contracts\Apis\SentencesApiInterface;
use App\DataObjects\Sentences\Sentence;
use App\DataObjects\Sentences\SentenceCollection;
use Vanderlee\Sentence\Sentence as VanderleeSentence;

class VanderleeePhpSentence implements SentencesApiInterface
{
    public function getSentences(string $caption): SentenceCollection
    {
        $collection = new SentenceCollection();
        $sentences = (new VanderleeSentence())->split($caption, VanderleeSentence::SPLIT_TRIM);

        foreach ($sentences as $index => $sentenceString) {
            $collection->add(new Sentence($sentenceString, $index));
        }

        return $collection;
    }
}
