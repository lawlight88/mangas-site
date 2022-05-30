<?php

namespace App\Http\Requests;

use App\Models\Manga;
use Illuminate\Foundation\Http\FormRequest;

class MangaStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
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
            'genres' => 'required|array|min:1|max:33',
            'genres.*' => 'required|distinct|integer|min:0|max:32',
            'cover' => 'required|mimes:jpeg,jpg,png,pdf|max:2048',
        ];

        if(url()->previous() == route('manga.create')) {
            $rules['cover'] = 'required|image|max:2048';
        }

        return $rules; 
    }
}
