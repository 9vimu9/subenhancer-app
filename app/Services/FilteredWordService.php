<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Services\FilteredWordServiceInterface;
use App\DataObjects\Sentences\Sentence;
use App\Exceptions\WordNotInCorpusException;
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
        $cleansedWordArray = $this->stringToCleansedWordArray($sentence->getSentence());
        $filteredWordsInSentence = $this->getIntersectionOfWordArrays($cleansedWordArray, $filteredWordArray);
        if (count($filteredWordsInSentence)) {
            $this->saveCaptionWords($filteredWordsInSentence, $sentenceId);
        }

    }

    public function saveCaptionWords(array $filteredWordsInSentence, int $sentenceId): void
    {
        foreach ($filteredWordsInSentence as $order => $word) {
            try {
                Captionword::query()->create([
                    'order_in_sentence' => $order,
                    'sentence_id' => $sentenceId,
                    'corpus_id' => Corpus::query()->findByWordOrFail($word)->id,
                ]);
            } catch (WordNotInCorpusException $exception) {
                continue;
            }
        }
    }
}
