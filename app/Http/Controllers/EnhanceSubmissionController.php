<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Factories\ResourceFactory;
use App\Http\Requests\SubmitEnhanceRequest;
use App\Services\CaptionSetviceInterface;
use App\Services\DefinitionsServiceInterface;
use App\Services\EnhancementServiceInterface;
use App\Services\SrtParser\SrtParserInterface;
use App\Services\WordServiceInterface;
use App\Services\YoutubeCaptionsGrabberApi\YoutubeCaptionsGrabberApiInterface;
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
        CaptionSetviceInterface $captionService
    ): RedirectResponse {
        $resource = (new ResourceFactory())->generate(
            $request->file('subtitle_file'),
            $request->get('video_url'),
            $srtParser,
            $youtubeCaptionsGrabberApi,
        );
        $enhancementService->submitEnhancement(
            $resource,
            $definitionsService,
            $wordService,
            $captionService,

        );

        //        if ($request->hasFile('subtitle_file')) {
        //            return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'File has been added successfully for the enhancement. You will receive a notification shortly']]);
        //        }
        //
        //        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'YouTube video has been added successfully for the enhancement. You will receive a notification shortly']]);

    }
}
