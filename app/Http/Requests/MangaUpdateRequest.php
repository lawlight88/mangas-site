<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MangaUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'prohibited'
            ],
            'desc' => [
                'required',
                'min:10'
            ],
            'author' => [
                'required',
                'min:3',
                'max:255',
            ],
            'ongoing' => 'nullable',
            'genres' => 'required|array|min:1|max:33',
            'genres.*' => 'required|distinct|integer|min:0|max:32',
            'cover' => 'nullable|mimes:jpeg,jpg,png,pdf|max:2048',
        ];
    }
}
