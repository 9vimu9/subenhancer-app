<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Exceptions\EnhancementCannotBeFoundException;
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
        $uuid = 'RANDOM_UUID';
        $this->instance(
            Uuid::class,
            Mockery::mock('alias:'.Uuid::class, static function (MockInterface $mock) use ($uuid) {
                $mock->shouldReceive('uuid4')->once()->andReturn($uuid);
            })
        );

        Enhancement::query()->createByUserId($user->id);
        $this->assertDatabaseHas('enhancements', [
            'user_id' => $user->id,
            'uuid' => $uuid,
        ]);

    }

    public function test_update_source_id_method(): void
    {
        $enhancement = Enhancement::factory()->create(['source_id' => null]);
        $source = Source::factory()->create();
        Enhancement::query()->updateSourceId($enhancement->id, $source->id);
        $this->assertDatabaseHas('enhancements', ['source_id' => $source->id]);

    }

    public function test_throws_exception_when_the_enhancement_does_not_exist(): void
    {
        $source = Source::factory()->create();
        $this->expectException(EnhancementCannotBeFoundException::class);
        Enhancement::query()->updateSourceId(1, $source->id);

    }
}
