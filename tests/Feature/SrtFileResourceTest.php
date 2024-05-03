<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Srt;
use App\Resources\SrtFileResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SrtFileResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_true_when_the_file_is_already_in_the_table(): void
    {
        $srtFile = Srt::factory()->create();
        $file = UploadedFile::fake()->create($srtFile->getAttribute('file_location'));
        $srtFileResource = new SrtFileResource($file);
        $this->assertTrue($srtFileResource->isAlreadyExist());
    }

    public function test_returns_false_when_the_file_is_new(): void
    {
        $file = UploadedFile::fake()->create('new_file.srt');
        $srtFileResource = new SrtFileResource($file);
        $this->assertFalse($srtFileResource->isAlreadyExist());
    }
}
