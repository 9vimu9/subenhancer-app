<?php

declare(strict_types=1);

namespace App\Resources;

use App\Models\Srt;
use App\Services\Subtitles\Caption;
use App\Services\Subtitles\CaptionsCollection;
use Benlipp\SrtParser\Parser;
use Illuminate\Http\UploadedFile;

class SrtFileResource implements ResourceInterface
{
    public function __construct(private UploadedFile $file)
    {
    }

    public function isAlreadyExist(): bool
    {
        return Srt::query()->where('md5_hash', md5_file($this->file->getRealPath()))->exists();
    }

    public function fetch(): string
    {
        return $this->file->getContent();
    }

    public function toCaptions(string $captionsString): CaptionsCollection
    {
        $captionsCollection = new CaptionsCollection();
        $parser = new Parser();
        $parser->loadString($captionsString);
        foreach ($parser->parse() as $srt) {
            $caption = new Caption();
            $caption->setCaption($srt->text);
            $startTime = (int) round($srt->startTime * 1000);
            $endTime = (int) round($srt->endTime * 1000);
            $caption->setStartTime($startTime);
            $caption->setEndTime($endTime);
            $captionsCollection->addCaption($caption);
        }

        return $captionsCollection;
    }
}
