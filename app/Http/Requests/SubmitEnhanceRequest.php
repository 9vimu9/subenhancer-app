<?php

namespace App\Http\Requests;

use App\Rules\YouTubeURLRule;
use Illuminate\Foundation\Http\FormRequest;

class SubmitEnhanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'subtitle_file' => ['prohibited_unless:video_url,null', 'required_without:video_url', 'mimetypes:application/x-subrip', 'mimes:srt'],
            'video_url' => ['prohibited_unless:subtitle_file,null', 'required_without:subtitle_file'],
        ];
        if (is_null($this->file('subtitle_file')) || ! is_null($this->input('video_url'))) {
            $rules['video_url'][] = new YouTubeURLRule();
        }

        return $rules;
    }
}
