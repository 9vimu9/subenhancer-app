<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Enhancement;
use App\Models\Source;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class EnhancementQueryBuilderTest extends TestCase
{
    use RefreshDatabase;

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function test_create_by_user_id_method(): void
    {
        $user = User::factory()->create();
        $source = Source::factory()->create();
        $uuid = 'RANDOM_UUID';
        $this->instance(
            Uuid::class,
            Mockery::mock('alias:'.Uuid::class, static function (MockInterface $mock) use ($uuid) {
                $mock->shouldReceive('uuid4')->once()->andReturn($uuid);
            })
        );

        Enhancement::query()->createByUserId($user->id, $source->id);
        $this->assertDatabaseHas('enhancements', [
            'user_id' => $user->id,
            'uuid' => $uuid,
            'source_id' => $source->id,
        ]);

    }
}
