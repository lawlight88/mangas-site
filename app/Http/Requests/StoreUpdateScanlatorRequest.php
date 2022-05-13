<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateScanlatorRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|unique:scanlators,name|min:3|max:255',
            'desc' => 'nullable|max:255',
            'image' => 'nullable|image|max:2048',
            'leader' => 'prohibited', //change
        ];

        if(url()->previous() == route('scan.edit'))
            $rules['name'] = 'prohibited';

        return $rules;
    }
}
