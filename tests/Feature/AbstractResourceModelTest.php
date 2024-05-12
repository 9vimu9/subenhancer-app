<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Exceptions\TryingToStoreRecordForNonPolymorphicallyRelatedTableException;
use App\Models\ResourceModels\AbstractResourceModel;
use App\Models\ResourceModels\YoutubeResourceModel;
use App\Models\Youtubevideo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AbstractResourceModelTest extends TestCase
{
    use RefreshDatabase;

    const string YOUTUBE_URL = 'https://www.youtube.com/watch?v=';

    public function test_saveToSource(): void
    {
        (new YoutubeResourceModel(self::YOUTUBE_URL.'my_video_id'))->saveToSource();
        $this->assertDatabaseHas('sources', ['sourceable_type' => Youtubevideo::class, 'sourceable_id' => 1]);
    }

    public function test_saveToSource_throws_exception_when_the_model_is_not_in_polymorphiric_raltionship(): void
    {

        $youtubeResourceModel = new class extends AbstractResourceModel
        {
            public function resourceExists(): bool
            {
                return true;
            }

            public function save(): Model
            {
                return new class extends Model
                {
                };
            }
        };

        $this->expectException(TryingToStoreRecordForNonPolymorphicallyRelatedTableException::class);
        $youtubeResourceModel->saveToSource();

    }
}
