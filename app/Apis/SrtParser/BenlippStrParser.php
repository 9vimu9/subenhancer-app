<?php

declare(strict_types=1);

namespace App\Apis\SrtParser;

use App\DataObjects\Captions\Caption;
use App\DataObjects\Captions\CaptionsCollection;
use Benlipp\SrtParser\Parser;

class BenlippStrParser implements SrtParserInterface
{
    public function __construct(private CaptionsCollection $captionsCollection)
    {
    }

    public function parse(string $fileContent): CaptionsCollection
    {
        $parser = new Parser();
        $parser->loadString($fileContent);
        foreach ($parser->parse() as $srt) {
            $caption = new Caption();
            $caption->setCaption($srt->text);
            $startTime = (int) round($srt->startTime * 1000);
            $endTime = (int) round($srt->endTime * 1000);
            $caption->setStartTime($startTime);
            $caption->setEndTime($endTime);
            $this->captionsCollection->add($caption);
        }

        return $this->captionsCollection;
    }
}