<?php

declare(strict_types=1);

namespace App\Apis\SrtParser;

use App\Core\Contracts\Apis\SrtParserInterface;
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
            $this->captionsCollection->add(new Caption(
                captionString: $srt->text,
                startTime: (int) round($srt->startTime * 1000),
                endTime: (int) round($srt->endTime * 1000),
            )
            );
        }

        return $this->captionsCollection;
    }
}
