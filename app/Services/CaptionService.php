<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Services\CaptionServiceInterface;
use App\Core\Contracts\Services\DefinitionSelectorServiceInterface;
use App\Core\Contracts\Services\SentenceServiceInterface;
use App\Core\Database\LastInsertedIdTrait;
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
    use LastInsertedIdTrait, StringArrayOperationsTrait;

    public function processResource(
        DefinitionSelectorServiceInterface $definitionSelectorService,
        SentenceServiceInterface $sentenceService,
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

        Corpus::query()->with('definitions:id,definition,corpus_id')
            ->whereIn('word', $filteredWords)
            ->select(['word', 'id'])->get()->each(
                function (Corpus $corpus) use (&$filteredWordsWithIdsArray) {
                    $filteredWordsWithIdsArray[] = [
                        'id' => $corpus->id,
                        'word' => $corpus->word,
                        'definitions' => $corpus->definitions->toArray(),
                    ];
                });
        foreach ($captionsCollection as $caption) {
            $nextDurationId = $currentDurationId + 1;
            $durations->add(
                new DurationDto(
                    id: $nextDurationId,
                    startTime: $caption->getStartTime(),
                    endTime: $caption->getEndTime(),
                    sourceId: $sourceId
                )
            );
            foreach ($sentenceService->captionToSentences($caption) as $sentence) {
                $nextSentenceId = $currentSentenceId + 1;
                $sentences->add(
                    new SentenceDto(
                        id: $nextSentenceId,
                        order: $sentence->getOrder(),
                        sentence: $sentence->getSentence(),
                        durationId: $nextDurationId
                    )
                );

                $filteredWordsInSentence = $this->getIncludedFilteredWordsInTheSentence($sentence->getSentence(), $filteredWordsWithIdsArray);

                foreach ($filteredWordsInSentence as $order => $filteredWord) {
                    $nextFilteredWordId = $currentFilteredWordId + 1;
                    $captionWords->add(new CaptionwordDto(
                        id: $nextFilteredWordId,
                        order: $order,
                        sentenceId: $nextSentenceId,
                        definitionId: $definitionSelectorService->findMostSuitableDefinitionId($sentence, $filteredWord, $order)
                    ));

                    $currentFilteredWordId = $nextFilteredWordId;
                }
                $currentSentenceId = $nextSentenceId;
            }
            $currentDurationId = $nextDurationId;
        }
        Duration::query()->insertOrIgnore($durations->toArray());
        Sentence::query()->insertOrIgnore($sentences->toArray());
        Captionword::query()->insertOrIgnore($captionWords->toArray());
    }
}
