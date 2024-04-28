<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubmitEnhanceRequest;
use Illuminate\Http\RedirectResponse;

class EnhanceSubmissionController extends Controller
{
    public function submit(SubmitEnhanceRequest $request): RedirectResponse
    {
        //        dd($request->file('subtitle_file')->getMimeType(),$request->file('subtitle_file')->getClientOriginalExtension() );
        return redirect()->back();

    }
}
