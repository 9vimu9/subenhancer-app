<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Contracts\Services\DefinitionSelectorServiceInterface;
use App\Core\Contracts\Services\SentenceServiceInterface;
use App\DataObjects\Captions\Caption;
use App\DataObjects\Captions\CaptionsCollection;
use App\DataObjects\Sentences\Sentence;
use App\DataObjects\Sentences\SentenceCollection;
use App\Models\Corpus;
use App\Models\Definition;
use App\Models\Source;
use App\Services\CaptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class CaptionServiceTest extends TestCase
{
    use RefreshDatabase;

    const int SOURCE_ID = 1;

    const string WORD_1 = 'rw_1';

    const string WORD_2 = 'rw_2';

    const string WORD_3 = 'rw_3';

    const int SELECTED_DEFINITION_ID_FOR_WORD_1 = 1;

    const int SELECTED_DEFINITION_ID_FOR_WORD_2 = 2;

    const int SELECTED_DEFINITION_ID_FOR_WORD_3 = 3;

    const int ID_FOR_WORD_1 = 1;

    const int ID_FOR_WORD_2 = 2;

    const int ID_FOR_WORD_3 = 3;

    const string SENTENCE_ONE = 'Random '.self::WORD_1.' woRds '.self::WORD_2.' Here.';

    const string SENTENCE_TWO = 'anotther Random '.self::WORD_2.' woRds '.self::WORD_1.' Here.';

    const string CAPTION = self::SENTENCE_ONE.' '.self::SENTENCE_TWO;

    const int START_TIME = 100;

    const int END_TIME = 200;

    const string SELECTED_DEFINITION_FOR_WORD_1 = 'What the hell is going here 1';

    const string SELECTED_DEFINITION_FOR_WORD_2 = 'What the hell is going here 2';

    const string SELECTED_DEFINITION_FOR_WORD_3 = 'What the hell is going here 3';

    protected function setUp(): void
    {
        parent::setUp();
        $source = Source::factory()->create(['id' => self::SOURCE_ID]);

        $wordOne = Corpus::factory()->create(['id' => self::ID_FOR_WORD_1, 'word' => self::WORD_1]);
        Definition::factory()->create(['id' => self::SELECTED_DEFINITION_ID_FOR_WORD_1, 'corpus_id' => $wordOne->id]);

        $wordTwo = Corpus::factory()->create(['id' => self::ID_FOR_WORD_2, 'word' => self::WORD_2]);
        Definition::factory()->create(['id' => self::SELECTED_DEFINITION_ID_FOR_WORD_2, 'corpus_id' => $wordTwo->id]);

        $wordThree = Corpus::factory()->create(['id' => self::ID_FOR_WORD_3, 'word' => self::WORD_3]);
        Definition::factory()->create(['id' => self::SELECTED_DEFINITION_ID_FOR_WORD_3, 'corpus_id' => $wordThree->id]);
    }

    public function test_processResourceMethod(): void
    {

        $captionCollection = new CaptionsCollection(
            new Caption(self::CAPTION, 100, 200),
        );

        $definitionSelectorService = new class implements DefinitionSelectorServiceInterface
        {
            public function findMostSuitableDefinitionId(Sentence $sentence, array $wordArray, int $orderInTheSentence): ?int
            {
                return match ($wordArray['word']) {
                    CaptionServiceTest::WORD_1 => CaptionServiceTest::SELECTED_DEFINITION_ID_FOR_WORD_1,
                    CaptionServiceTest::WORD_2 => CaptionServiceTest::SELECTED_DEFINITION_ID_FOR_WORD_2,
                    CaptionServiceTest::WORD_3 => CaptionServiceTest::SELECTED_DEFINITION_ID_FOR_WORD_3,
                };

            }
        };
        $sentenceService = new class implements SentenceServiceInterface
        {
            public function captionToSentences(Caption $caption): SentenceCollection
            {
                return new SentenceCollection(
                    new Sentence(CaptionServiceTest::SENTENCE_ONE, 0),
                    new Sentence(CaptionServiceTest::SENTENCE_TWO, 1),
                );

            }
        };
        $mock = Mockery::mock(CaptionService::class, [$definitionSelectorService, $sentenceService])->makePartial();

        $mock->shouldReceive('getIncludedFilteredWordsInTheSentence')
            ->andReturn([
                [
                    'id' => self::ID_FOR_WORD_1,
                    'word' => self::WORD_1,
                    'definitions' => [
                        [
                            'id' => self::SELECTED_DEFINITION_ID_FOR_WORD_1,
                            'definition' => self::SELECTED_DEFINITION_FOR_WORD_1,
                            'corpus_id' => self::ID_FOR_WORD_1],
                    ],
                ],
                [
                    'id' => self::ID_FOR_WORD_2,
                    'word' => self::WORD_2,
                    'definitions' => [
                        [
                            'id' => self::SELECTED_DEFINITION_ID_FOR_WORD_2,
                            'definition' => self::SELECTED_DEFINITION_FOR_WORD_2,
                            'corpus_id' => self::ID_FOR_WORD_2],
                    ],
                ],
            ]);
        $mock->shouldReceive('getLastInsertedId')
            ->andReturn(0);

        $mock->processResource(
            captionsCollection: $captionCollection,
            sourceId: self::SOURCE_ID,
            filteredWords: [self::WORD_1, self::WORD_2, self::WORD_3],

        );
        $this->assertDatabaseHas('durations', ['id' => 1, 'start_time_in_millis' => self::START_TIME, 'end_time_in_millis' => self::END_TIME]);
        $this->assertDatabaseHas('sentences', ['id' => 1, 'sentence' => self::SENTENCE_ONE]);
        $this->assertDatabaseHas('sentences', ['id' => 2, 'sentence' => self::SENTENCE_TWO]);
        $this->assertDatabaseHas('captionwords', ['id' => 1, 'sentence_id' => 1, 'definition_id' => self::SELECTED_DEFINITION_ID_FOR_WORD_1]);
        $this->assertDatabaseHas('captionwords', ['id' => 2, 'sentence_id' => 1, 'definition_id' => self::SELECTED_DEFINITION_ID_FOR_WORD_2]);
        $this->assertDatabaseHas('captionwords', ['id' => 3, 'sentence_id' => 2, 'definition_id' => self::SELECTED_DEFINITION_ID_FOR_WORD_1]);
        $this->assertDatabaseHas('captionwords', ['id' => 4, 'sentence_id' => 2, 'definition_id' => self::SELECTED_DEFINITION_ID_FOR_WORD_2]);
    }
}
