<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Factories\ResourceFactory;
use App\Http\Requests\SubmitEnhanceRequest;
use App\Services\DefinitionsAPI\FreeDictionaryApi;
use App\Services\EnhancementService;
use App\Services\SentencesApi\FirstPartySentencingApi;
use App\Services\SrtParser\BenlippStrParser;
use App\Services\WordsFilterApi\FirstPartyWordFilterApi;
use App\Services\YoutubeCaptionsGrabberApi\FirstPartyYoutubeCaptionsGrabberApi;
use Illuminate\Http\RedirectResponse;

class EnhanceSubmissionController extends Controller
{
    public function submit(SubmitEnhanceRequest $request, EnhancementService $enhancementService): RedirectResponse
    {
        $definitionApi = new FreeDictionaryApi();
        $sentencingApi = new FirstPartySentencingApi();
        $srtParser = new BenlippStrParser();
        $youtubeCaptionsGrabberApi = new FirstPartyYoutubeCaptionsGrabberApi();
        $wordFilterApi = new FirstPartyWordFilterApi();
        $resource = (new ResourceFactory())->generate(
            $request->file('subtitle_file'),
            $request->get('video_url'),
            $srtParser,
            $youtubeCaptionsGrabberApi,
        );
        $enhancementService->submitEnhancement($resource, $definitionApi, $sentencingApi, $wordFilterApi);

        //        if ($request->hasFile('subtitle_file')) {
        //            return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'File has been added successfully for the enhancement. You will receive a notification shortly']]);
        //        }
        //
        //        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'YouTube video has been added successfully for the enhancement. You will receive a notification shortly']]);

    }
}
