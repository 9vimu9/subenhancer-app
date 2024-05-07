<?php

declare(strict_types=1);

namespace App\Services\Captions;

use App\Exceptions\DurationHasnotBeenSavedBeforeSaveCaptionInSentencesException;
use App\Models\Duration;
use App\Models\Sentence;
use App\Services\Sentences\SentenceCollection;
use App\Services\SentencesApi\SentencesApiInterface;

class Caption
{
    private string $captionString;

    private int $startTime;

    private int $endTime;

    private Duration $duration;

    public function setCaption(string $captionString): void
    {
        $this->captionString = $captionString;
    }

    public function setStartTime(int $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function setEndTime(int $endTime): void
    {
        $this->endTime = $endTime;
    }

    public function getCaption(): string
    {
        return $this->captionString;
    }

    public function getStartTime(): int
    {
        return $this->startTime;
    }

    public function getEndTime(): int
    {
        return $this->endTime;
    }

    /**
     * @param  array<int, string>  $filteredWord
     */
    public function hasFilteredWordInCaption(array $filteredWord): bool
    {
        $filteredWord = array_map('strtolower', $filteredWord);
        $sentenceToWordArray = preg_split('/\s+/', strtolower($this->getCaption()));

        return (bool) count(array_intersect($sentenceToWordArray, $filteredWord));
    }

    public function saveDuration(int $sourceId): Duration
    {
        $this->duration = Duration::query()->create([
            'start_time_in_millis' => $this->getStartTime(),
            'end_time_in_millis' => $this->getEndTime(),
            'source_id' => $sourceId,
        ]);

        return $this->duration;
    }

    public function saveSentencesInTheCaption(SentencesApiInterface $sentencesApi): SentenceCollection
    {
        if (! isset($this->duration)) {
            throw new DurationHasnotBeenSavedBeforeSaveCaptionInSentencesException();
        }
        $collection = new SentenceCollection();
        foreach ($sentencesApi->getSentences($this->getCaption())->toArray() as $sentence) {
            $sentenceModel = Sentence::query()->create([
                'order' => $sentence->getOrder(),
                'sentence' => $sentence->getSentence(),
                'duration_id' => $this->duration->getAttribute('id'),
            ]);
            $sentence->setSentenceModel($sentenceModel);
            $collection->addSentence($sentence);

        }

        return $collection;

    }
}
