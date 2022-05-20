<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class PageStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $max = 100;
        if(url()->previous() != route('manga.edit', $this->manga)) {
            $qty_temp_files = count(Storage::disk('temp')->allFiles($this->manga->id));
            $max = 100 - $qty_temp_files;
        }

        return [
            'pages' => "required|array|min:1|max:$max",
            'pages.*' => 'required|max:2048|mimes:jpeg,jpg,png,pdf'
        ];
    }

    public function messages()
    {
        return [
            'pages.required' => 'There are not any image.',
            'pages.min' => 'It is necessary at least 1 image.',
            'pages.*.required' => 'There are not any image.',
            'pages.*.mimes' => 'The files must be of the following types: :values.'
        ];
    }
}
