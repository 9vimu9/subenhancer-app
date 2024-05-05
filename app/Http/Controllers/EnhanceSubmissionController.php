<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Factories\ResourceFactory;
use App\Http\Requests\SubmitEnhanceRequest;
use App\Services\EnhancementService;
use Illuminate\Http\RedirectResponse;

class EnhanceSubmissionController extends Controller
{
    public function submit(SubmitEnhanceRequest $request, EnhancementService $enhancementService): RedirectResponse
    {
        $enhancementService->create(auth()->id());
        $resource = (new ResourceFactory())->generate(
            $request->file('subtitle_file'), $request->get('video_url'));
        if ($resource->isAlreadyExist()) {
            var_dump('dddd');
            exit;
        }
        if ($request->hasFile('subtitle_file')) {
            return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'File has been added successfully for the enhancement. You will receive a notification shortly']]);
        }

        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'YouTube video has been added successfully for the enhancement. You will receive a notification shortly']]);

    }
}
