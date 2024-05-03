<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubmitEnhanceRequest;
use Illuminate\Http\RedirectResponse;

class EnhanceSubmissionController extends Controller
{
    public function submit(SubmitEnhanceRequest $request): RedirectResponse
    {
        if ($request->hasFile('subtitle_file')) {
            return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'File has been added successfully for the enhancement. You will receive a notification shortly']]);
        }

        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'YouTube video has been added successfully for the enhancement. You will receive a notification shortly']]);

    }
}
