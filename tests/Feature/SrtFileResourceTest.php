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

    public function test_fetch_for_srt_file(): void
    {
        $fileContent = 'FILE_CONTENT';
        $file = UploadedFile::fake()->create('new_file.srt', $fileContent);
        $srtFileResource = new SrtFileResource($file);
        $this->assertEquals($fileContent, $srtFileResource->fetch());
    }

    public function test_toCaptions_method(): void
    {
        $fileContent =
'1
00:01:03,063 --> 00:01:06,148
A Film Poeta Production

2
00:01:08,443 --> 00:01:13,864
A DIRTY CARNIVAL';

        $file = UploadedFile::fake()->create('new_file.srt', $fileContent);

        $captionsCollection = (new SrtFileResource($file))->toCaptions($fileContent);
        $captions = $captionsCollection->captions();

        $this->assertEquals('A Film Poeta Production', $captions[0]->getCaption());
        $this->assertEquals(63063, $captions[0]->getStartTime());
        $this->assertEquals(66148, $captions[0]->getEndTime());

        $this->assertEquals('A DIRTY CARNIVAL', $captions[1]->getCaption());
        $this->assertEquals(68443, $captions[1]->getStartTime());
        $this->assertEquals(73864, $captions[1]->getEndTime());
    }

    public function test_relocateFile(): void
    {
        $file = UploadedFile::fake()->create('new_file.srt', 'OHhh CONTENT');
        $originalFileHash = md5_file($file->getRealPath());
        $resource = new SrtFileResource($file);
        $resource->relocateFile();
        $this->assertEquals($originalFileHash, md5_file($resource->getFile()->getRealPath()));
    }

    public function test_srt_resource_can_be_recorded_to_srts_table(): void
    {
        $file = UploadedFile::fake()->create('new_file.srt', 'OHhh CONTENT');
        $originalFileHash = md5_file($file->getRealPath());
        $resource = new SrtFileResource($file);
        $resource->storeResourceTable();
        $this->assertDatabaseHas('srts', ['md5_hash' => $originalFileHash, 'file_location' => $file->getRealPath()]);
    }
}
