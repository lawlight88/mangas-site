<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pages' => 'required|array|min:2|max:100',
            'pages.*' => 'required|max:2048|mimes:jpeg,jpg,png,pdf'
        ];
    }

    public function messages()
    {
        return [
            'pages.required' => 'There are not any image.',
            'pages.min' => 'It is necessary at least 2 images.',
            'pages.*.required' => 'There are not any image.',
            'pages.*.mimes' => 'The files must be of the following types: :values.'
        ];
    }
}
