<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class SrtFactory extends Factory
{
    public function definition(): array
    {
        $filePath = $this->faker->filePath().'.srt';

        return [
            'file_location' => $filePath,
            'md5_hash' => md5(UploadedFile::fake()->create($filePath)->getContent()),
        ];
    }
}
