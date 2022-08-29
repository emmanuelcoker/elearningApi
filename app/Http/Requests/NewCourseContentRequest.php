<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewCourseContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'curriculum_id'     => 'required|numeric',
            'filename'          => 'required|mimes:csv,txt,xlx,xls,pdf,docs,docx,ppt,flv,mp4,mkv,m3u8,avi,mov,ts,wmv'
        ];
    }
}
