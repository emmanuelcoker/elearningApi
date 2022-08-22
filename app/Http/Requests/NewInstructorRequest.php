<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewInstructorRequest extends FormRequest
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
            'about' => 'required',
            'sub_title' => 'required',
            'website_link' => 'nullable',
            'twitter_link' => 'nullable',
            'youtube_link'  => 'nullable',
            'linkedin_link' => 'nullable' 
        ];
    }
}
