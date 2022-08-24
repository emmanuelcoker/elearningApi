<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewCourseRequest extends FormRequest
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
            'description'        => 'required',
            'title'              => 'required',
            'audience'           => 'required',
            'start_day'          => 'required',
            'end_day'            => 'required',
            'requirements'       => 'required',
            'prerequisites'      => 'required',
            'pricing'            => 'required',
            'banner_img'         => 'required',
            'course_category_id' => 'required'
        ];
    }
}
