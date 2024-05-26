<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Services\FilteredWordServiceInterface;
use App\DataObjects\Sentences\Sentence;
use App\Events\NewFilteredWordsStored;
use App\Models\Captionword;
use App\Models\Corpus;
use App\Traits\StringArrayOperationsTrait;

class FilteredWordService implements FilteredWordServiceInterface
{
    use StringArrayOperationsTrait;

    public function saveFilteredWordWhichFoundInSentence(
        array $filteredWordArray,
        Sentence $sentence,
        int $sentenceId): void
    {
        $filteredWordsInSentence = $this->getIncludedFilteredWordsInTheSentence($sentence->getSentence(), $filteredWordArray);
        if (count($filteredWordsInSentence)) {
            $this->saveFilteredWords($filteredWordsInSentence, $sentence, $sentenceId);
        }

    }

    private function saveFilteredWords(array $filteredWordsInSentence, Sentence $sentence, int $sentenceId): void
    {
        foreach ($filteredWordsInSentence as $order => $word) {
            if (is_null(
                $corpus = Corpus::query()->findByWord($word)
            )) {
                continue;
            }
            $filteredWord = Captionword::query()->create([
                'order_in_sentence' => $order,
                'sentence_id' => $sentenceId,
            ]);
            NewFilteredWordsStored::dispatch(
                $filteredWord->getAttribute('id'),
                $sentence,
                $sentenceId,
                $corpus->id,
                $order
            );

        }
    }
}
