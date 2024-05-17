<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Contracts\Apis\SrtParserInterface;
use App\Core\Contracts\Apis\YoutubeCaptionsGrabberApiInterface;
use App\DataObjects\Captions\CaptionsCollection;
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
        (new ResourceFactory())->generate(
            null,
            null,
            new MockSrtParser(),
            new MockYoutubeCaptionsGrabberApi());
    }

    public function test_youtube_video_resource_can_be_created(): void
    {
        $resource = (new ResourceFactory())->generate(
            null,
            'https://www.youtube.com/watch?v=afsgs',
            new MockSrtParser(),
            new MockYoutubeCaptionsGrabberApi(),
        );
        $this->assertInstanceOf(YoutubeUrlResource::class, $resource);
    }

    public function test_srt_file_resource_can_be_created(): void
    {
        $file = UploadedFile::fake()->create('srt_file.srt', 'TEST CONTENT');
        $resource = (new ResourceFactory())->generate(
            $file,
            null,
            new MockSrtParser(),
            new MockYoutubeCaptionsGrabberApi(),
        );
        $this->assertInstanceOf(SrtFileResource::class, $resource);
    }
}

class MockSrtParser implements SrtParserInterface
{
    public function parse(string $fileContent): CaptionsCollection
    {
        return new CaptionsCollection();
    }
}

class MockYoutubeCaptionsGrabberApi implements YoutubeCaptionsGrabberApiInterface
{
    public function getCaptions(string $videoId): string
    {
        return 'RANDOM TEXT';
    }
}
