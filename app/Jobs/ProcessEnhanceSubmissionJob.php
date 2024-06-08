<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Core\Contracts\Resource\ResourceInterface;
use App\Core\Contracts\Services\CaptionServiceInterface;
use App\Core\Contracts\Services\DefinitionsServiceInterface;
use App\Core\Contracts\Services\EnhancementServiceInterface;
use App\Core\Contracts\Services\VocabularyServiceInterface;
use App\Core\Contracts\Services\WordServiceInterface;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessEnhanceSubmissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private User $user,
        private string $enhancementName,
        private EnhancementServiceInterface $enhancementService,
        private DefinitionsServiceInterface $definitionsService,
        private WordServiceInterface $wordService,
        private CaptionServiceInterface $captionService,
        private VocabularyServiceInterface $vocabularyService,
        private ResourceInterface $resource
    ) {

    }

    public function handle(): void
    {
        $this->enhancementService->submitEnhancement(
            $this->user,
            $this->enhancementName,
            $this->resource,
            $this->definitionsService,
            $this->wordService,
            $this->captionService,
            $this->vocabularyService
        );
    }
}
