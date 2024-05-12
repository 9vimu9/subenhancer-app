<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Traits\FileResourceTrait;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FileResourceTraitTest extends TestCase
{
    use FileResourceTrait;

    public function test_relocateFile(): void
    {
        $uploadedFile = UploadedFile::fake()->create('fake_file.srt', 'FAKE FILE CONTENT');
        $movedFile = $this->relocateFile($uploadedFile);
        $this->assertEquals('/var/www/html/storage/app', $movedFile->getPath());
    }
}
