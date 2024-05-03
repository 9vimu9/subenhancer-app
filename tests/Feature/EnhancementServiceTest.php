<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use App\Services\EnhancementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnhancementServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_enhancement_can_be_created(): void
    {
        $this->seed();

        $userId = User::query()->where('email', config('app.demo.generic_user_email'))->first()->getAttribute('id');
        $enhancementService = new EnhancementService();

        $enhancement = $enhancementService->create($userId);
        $this->assertSame($userId, $enhancement->getAttribute('id'));
        $this->assertDatabaseHas('enhancements', ['user_id' => $userId]);

    }
}
