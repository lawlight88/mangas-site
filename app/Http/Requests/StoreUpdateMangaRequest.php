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
        $rules = [
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
            'ongoing' => 'nullable',
            'genres' => 'required|array',
            'cover' => 'nullable|image|max:2048',
        ];

        if(url()->previous() == route('manga.create')) {
            $rules['cover'] = 'required|image|max:2048';
        }

        return $rules; 
    }
}
