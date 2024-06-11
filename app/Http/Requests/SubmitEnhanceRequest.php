<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Core\Contracts\Dtos\Dtoable;
use App\Dtos\SubmitEnhanceRequestDto;
use App\Rules\YouTubeURLRule;
use Illuminate\Foundation\Http\FormRequest;

class SubmitEnhanceRequest extends FormRequest implements Dtoable
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'subtitle_file' => ['prohibited_unless:video_url,null', 'required_without:video_url', 'mimetypes:application/x-subrip', 'mimes:srt', 'file', 'max:2048'],
            'video_url' => ['prohibited_unless:subtitle_file,null', 'required_without:subtitle_file', 'string', 'max:255'],
        ];
        if (is_null($this->file('subtitle_file')) || ! is_null($this->input('video_url'))) {
            $rules['video_url'][] = new YouTubeURLRule();
        }

        return $rules;
    }

    public function toDto(): SubmitEnhanceRequestDto
    {
        return new SubmitEnhanceRequestDto(
            name: $this->input('name'),
            subtitleFile: $this->file('subtitle_file'),
            videoUrl: $this->input('video_url'),
        );
    }
}
