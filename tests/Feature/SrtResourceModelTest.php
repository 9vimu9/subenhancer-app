<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\ResourceModels\SrtResourceModel;
use App\Models\Srt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SrtResourceModelTest extends TestCase
{
    use RefreshDatabase;

    public static function provideFakeFile(): array
    {
        return [[UploadedFile::fake()->create('fake_file.srt', 'FAKE FILE CONTENT')]];

    }

    #[DataProvider('provideFakeFile')]
    public function test_returns_true_when_the_file_is_already_in_the_table(UploadedFile $fakeFile): void
    {
        $srtFile = Srt::factory()->create(['file_location' => $fakeFile->getRealPath(), 'md5_hash' => md5_file($fakeFile->getRealPath())]);
        $srtResourceModel = new SrtResourceModel($srtFile->getAttribute('file_location'));
        $this->assertTrue($srtResourceModel->resourceExists());
    }

    #[DataProvider('provideFakeFile')]
    public function test_returns_false_when_the_file_is_new(UploadedFile $fakeFile): void
    {
        $this->assertFalse(
            (new SrtResourceModel($fakeFile->getRealPath()))
                ->resourceExists());
    }

    #[DataProvider('provideFakeFile')]
    public function test_save_to_srt_table(UploadedFile $fakeFile): void
    {

        (new SrtResourceModel($fakeFile->getRealPath()))->save();
        $this->assertDatabaseHas('srts', ['file_location' => $fakeFile->getRealPath()]);
    }
}
