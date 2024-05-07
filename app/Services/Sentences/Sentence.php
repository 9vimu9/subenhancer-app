<?php

declare(strict_types=1);

namespace App\Services\Sentences;

use App\Models\Captionword;
use App\Models\Corpus;
use App\Services\Captions\Caption;

class Sentence
{
    private Caption $caption;

    private \App\Models\Sentence $sentenceModel;

    private string $sentence;

    public function getSentence(): string
    {
        return $this->sentence;
    }

    private int $order;

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setCaption(Caption $caption): void
    {
        $this->caption = $caption;
    }

    public function setSentence(string $sentence): void
    {
        $this->sentence = $sentence;
    }

    public function setOrder(int $order): void
    {
        $this->order = $order;
    }

    public function saveFilteredWordsWhichFoundInSentenceToCaptionword(array $filteredWords): void
    {
        $filteredWords = array_map('strtolower', $filteredWords);
        $sentenceToWordArray = preg_split('/\s+/', strtolower($this->sentence));
        $filteredWordsInSentence = array_intersect($sentenceToWordArray, $filteredWords);
        if (! count($filteredWordsInSentence)) {
            return;
        }
        foreach ($filteredWordsInSentence as $order => $word) {
            Captionword::query()->create([
                'order_in_sentence' => $order,
                'sentence_id' => $this->sentenceModel->getAttribute('id'),
                'corpus_id' => Corpus::query()->findByWord($word)->id,
            ]);
        }

    }

    public function getSentenceModel(): \App\Models\Sentence
    {
        return $this->sentenceModel;
    }

    public function setSentenceModel(\App\Models\Sentence $sentenceModel): void
    {
        $this->sentenceModel = $sentenceModel;
    }
}
