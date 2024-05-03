<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Exceptions\ResourceGenerationInputsAreNullException;
use App\Factories\ResourceFactory;
use App\Resources\SrtFileResource;
use App\Resources\YoutubeUrlResource;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;

class ResourceFactoryTest extends TestCase
{
    public function test_exception_being_thrown_when_both_the_inputs_are_null(): void
    {
        $this->expectException(ResourceGenerationInputsAreNullException::class);
        (new ResourceFactory())->generate(null, null);
    }

    public function test_youtube_video_resource_can_be_created(): void
    {
        $resource = (new ResourceFactory())->generate(null, 'random_link');
        $this->assertInstanceOf(YoutubeUrlResource::class, $resource);
    }

    public function test_srt_file_resource_can_be_created(): void
    {
        $file = UploadedFile::fake()->create('srt_file.srt');
        $resource = (new ResourceFactory())->generate($file, null);
        $this->assertInstanceOf(SrtFileResource::class, $resource);
    }
}
