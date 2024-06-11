<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Contracts\Apis\SrtParserInterface;
use App\Core\Contracts\Apis\YoutubeCaptionsGrabberApiInterface;
use App\Core\Contracts\Services\CaptionServiceInterface;
use App\Core\Contracts\Services\DefinitionsServiceInterface;
use App\Core\Contracts\Services\EnhancementServiceInterface;
use App\Core\Contracts\Services\VocabularyServiceInterface;
use App\Core\Contracts\Services\WordServiceInterface;
use App\Factories\ResourceFactory;
use App\Http\Requests\SubmitEnhanceRequest;
use App\Jobs\ProcessEnhanceSubmissionJob;
use Illuminate\Http\RedirectResponse;

class EnhanceSubmissionController extends Controller
{
    public function submit(
        SubmitEnhanceRequest $request,
        EnhancementServiceInterface $enhancementService,
        SrtParserInterface $srtParser,
        YoutubeCaptionsGrabberApiInterface $youtubeCaptionsGrabberApi,
        DefinitionsServiceInterface $definitionsService,
        WordServiceInterface $wordService,
        CaptionServiceInterface $captionService,
        VocabularyServiceInterface $vocabularyService,
    ): RedirectResponse {
        $dto = $request->toDto();
        $resource = (new ResourceFactory())->generate(
            $dto->subtitleFile,
            $dto->videoUrl,
            $srtParser,
            $youtubeCaptionsGrabberApi,
        );
        ProcessEnhanceSubmissionJob::dispatch(
            auth()->user(),
            $dto->name,
            $enhancementService,
            $definitionsService,
            $wordService,
            $captionService,
            $vocabularyService,
            $resource,
        );
        if ($request->hasFile('subtitle_file')) {
            return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'File has been added successfully for the enhancement. You will receive a notification shortly']]);
        }

        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'YouTube video has been added successfully for the enhancement. You will receive a notification shortly']]);

    }
}
