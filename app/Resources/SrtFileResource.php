<?php

declare(strict_types=1);

namespace App\Resources;

use App\Core\Contracts\Apis\SrtParserInterface;
use App\DataObjects\Captions\CaptionsCollection;
use App\Models\ResourceModels\ResourceModelInterface;
use Illuminate\Http\UploadedFile;

class SrtFileResource extends AbstractResource
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
