<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitEnhanceRequest;

class EnhanceSubmissionController extends Controller
{
    public function submit(SubmitEnhanceRequest $request)
    {
        //        dd($request->file('subtitle_file')->getMimeType(),$request->file('subtitle_file')->getClientOriginalExtension() );
        var_export('fff');
        exit;

    }
}
