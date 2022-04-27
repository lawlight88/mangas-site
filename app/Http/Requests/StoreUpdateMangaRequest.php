<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateMangaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  //temp------------------
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'unique:mangas,name',
                'max:255',
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
            'pages' => [
                'required',
                'array',
                'min:2',
            ],
            'ongoing' => [
                'nullable',
            ],
            'genres' => [
                'required',
                'array',
            ],
        ];
    }
}
