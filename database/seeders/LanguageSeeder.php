<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\LanguageEnum;
use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        foreach (LanguageEnum::cases() as $language) {
            Language::query()->create([
                'name' => $language->name,
            ]);
        }
    }
}
