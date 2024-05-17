<?php

declare(strict_types=1);

namespace App\Resources;

use App\DataObjects\Captions\CaptionsCollection;
use App\Models\ResourceModels\ResourceModelInterface;
use App\Services\SrtParser\SrtParserInterface;
use Illuminate\Http\UploadedFile;

class SrtFileResource extends AbstractFileResource
{
    public function __construct(
        protected UploadedFile $file,
        protected ResourceModelInterface $resourceModel,
        protected SrtParserInterface $srtParser,
    ) {
    }

    public function toCaptions(): CaptionsCollection
    {
        return $this->srtParser->parse($this->file->getContent());
    }
}
