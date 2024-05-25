<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\VocabularyEnum;
use App\Exceptions\UserHasNotBeenAuthenticatedException;
use App\Models\Definition;
use App\Models\User;
use App\Models\Vocabulary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VocabularyBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_method(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $definition = Definition::factory()->create();
        Vocabulary::query()->store(
            VocabularyEnum::HAVE_NOT_SPECIFIED,
            $definition->getAttribute('id'),
        );
        $this->assertDatabaseHas('vocabularies', [
            'definition_id' => $definition->id,
            'user_id' => $user->id]);

    }

    public function test_throw_exception_when_user_is_not_leogged_in(): void
    {
        $user = User::factory()->create();
        $definition = Definition::factory()->create();
        $this->expectException(UserHasNotBeenAuthenticatedException::class);
        Vocabulary::query()->store(
            VocabularyEnum::HAVE_NOT_SPECIFIED,
            $definition->getAttribute('id'),
        );
    }

    public function test_alreadyIncludedForTheUser_returns_true_when_word_is_added_for_the_user_to_vocabularies_table(): void
    {

        $user = User::factory()->create();
        $this->actingAs($user);
        $definition = Definition::factory()->create();
        $vocabulary = Vocabulary::factory()->create([
            'user_id' => $user->id,
            'definition_id' => $definition->id,
        ]);
        $this->assertTrue(Vocabulary::query()->alreadyIncludedForTheUser(
            $definition->getAttribute('id')
        ));
    }

    public function test_alreadyIncludedForTheUser_returns_false_when_word_is_not_added_for_the_user_to_vocabularies_table(): void
    {

        $user = User::factory()->create();
        $this->actingAs($user);
        $definition = Definition::factory()->create();
        $this->assertFalse(Vocabulary::query()->alreadyIncludedForTheUser(
            $definition->getAttribute('id')
        ));
    }

    public function test_alreadyIncludedForTheUser_throws_exception_when_no_user_loggedin(): void
    {

        $definition = Definition::factory()->create();
        $this->expectException(UserHasNotBeenAuthenticatedException::class);
        $this->assertFalse(Vocabulary::query()->alreadyIncludedForTheUser(
            $definition->getAttribute('id')
        ));
    }
}
