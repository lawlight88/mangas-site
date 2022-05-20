<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class PageOrderUpdateRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $qty_temp_files = count(Storage::disk('temp')->allFiles($this->manga->id));

        return [
            'orders' => "array|required|size:$qty_temp_files", //
            'orders.*' => "distinct|required|numeric|min:1|max:$qty_temp_files"
        ];
    }

    public function messages()
    {
        return [
            'orders.*.distinct' => 'Pages cannot have the same order.'
        ];
    }
}
