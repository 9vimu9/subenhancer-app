<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Services\CaptionServiceInterface;
use App\Core\Contracts\Services\DefinitionSelectorServiceInterface;
use App\Core\Contracts\Services\SentenceServiceInterface;
use App\Core\Database\LastInsertedIdTrait;
use App\DataObjects\Captions\Caption;
use App\DataObjects\Captions\CaptionsCollection;
use App\Dtos\CaptionwordDto;
use App\Dtos\CaptionwordDtoCollection;
use App\Dtos\DurationDto;
use App\Dtos\DurationDtoCollection;
use App\Dtos\SentenceDto;
use App\Dtos\SentenceDtoCollection;
use App\Models\Captionword;
use App\Models\Corpus;
use App\Models\Duration;
use App\Models\Sentence;
use App\Traits\StringArrayOperationsTrait;

class CaptionService implements CaptionServiceInterface
{
    public function __construct(
        private DefinitionSelectorServiceInterface $definitionSelectorService,
        private SentenceServiceInterface $sentenceService,
    ) {
    }

    use LastInsertedIdTrait, StringArrayOperationsTrait;

    public function processResource(
        CaptionsCollection $captionsCollection,
        int $sourceId,
        array $filteredWords,
    ): void {
        /*
                make sure these processes are queued. one resource at a time. this is FUCKING important
                Becasue we are going to assign PK manually.
                EVENTS ARE CANCELLED. no more freaking events.
         * */

        $durations = new DurationDtoCollection();
        $sentences = new SentenceDtoCollection();
        $captionWords = new CaptionwordDtoCollection();
        $currentDurationId = $this->getLastInsertedId('durations');
        $currentSentenceId = $this->getLastInsertedId('sentences');
        $currentFilteredWordId = $this->getLastInsertedId('captionwords');
        $filteredWordsWithIdsArray = [];

        Corpus::query()->filteredWordArrayToModels($filteredWords)->each(
            function (Corpus $corpus) use (&$filteredWordsWithIdsArray) {
                $filteredWordsWithIdsArray[] = [
                    'id' => $corpus->id,
                    'word' => $corpus->word,
                    'definitions' => $corpus->definitions->toArray(),
                ];
            });
        foreach ($captionsCollection as $caption) {
            $currentDurationId++;
            $durations->add(new DurationDto(id: $currentDurationId, startTime: $caption->getStartTime(), endTime: $caption->getEndTime(), sourceId: $sourceId));
            $this->processSentences(
                $caption,
                $currentSentenceId,
                $sentences,
                $currentDurationId,
                $filteredWordsWithIdsArray,
                $currentFilteredWordId,
                $captionWords);
        }
        Duration::query()->insertOrIgnore($durations->toArray());
        Sentence::query()->insertOrIgnore($sentences->toArray());
        Captionword::query()->insertOrIgnore($captionWords->toArray());
    }

    private function processSentences(
        Caption $caption,
        int &$currentSentenceId,
        SentenceDtoCollection $sentences,
        int $currentDurationId,
        array $filteredWordsWithIdsArray,
        int $currentFilteredWordId,
        CaptionwordDtoCollection $captionWords): void
    {
        foreach ($this->sentenceService->captionToSentences($caption) as $sentence) {
            $currentSentenceId++;
            $sentences->add(new SentenceDto(id: $currentSentenceId, order: $sentence->getOrder(), sentence: $sentence->getSentence(), durationId: $currentDurationId));
            $this->processFilteredWords($sentence, $filteredWordsWithIdsArray, $currentFilteredWordId, $captionWords, $currentSentenceId);
        }
    }

    private function processFilteredWords(
        \App\DataObjects\Sentences\Sentence $sentence,
        array $filteredWordsWithIdsArray,
        int &$currentFilteredWordId,
        CaptionwordDtoCollection $captionWords,
        int $currentSentenceId): void
    {
        $filteredWordsInSentence = $this->getIncludedFilteredWordsInTheSentence($sentence->getSentence(), $filteredWordsWithIdsArray);
        foreach ($filteredWordsInSentence as $order => $filteredWord) {
            $currentFilteredWordId++;
            $captionWords->add(new CaptionwordDto(id: $currentFilteredWordId, order: $order, sentenceId: $currentSentenceId, definitionId: $this->definitionSelectorService->findMostSuitableDefinitionId($sentence, $filteredWord, $order)));
        }
    }
}
