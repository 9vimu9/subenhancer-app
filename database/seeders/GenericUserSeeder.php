<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GenericUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->create([
            'name' => fake()->name(),
            'email' => config('app.demo.generic_user_email'),
            'email_verified_at' => now(),
            'password' => config('app.demo.generic_user_password'),
            'remember_token' => Str::random(10),        ]);
    }
}
