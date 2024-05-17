<?php

declare(strict_types=1);

namespace App\Resources;

use App\Core\Contracts\Apis\SrtParserInterface;
use App\Core\Contracts\Resource\AbstractResource;
use App\Core\Contracts\ResourceModels\ResourceModelInterface;
use App\DataObjects\Captions\CaptionsCollection;
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
