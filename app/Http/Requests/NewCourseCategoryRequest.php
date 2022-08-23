<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewCourseCategoryRequest extends FormRequest
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
            'category_name' => 'required|string',
            'banner_img' => 'required|image:jpeg,jpg,png',
            'info'=> 'required|string|min:20'
        ];
    }
}
