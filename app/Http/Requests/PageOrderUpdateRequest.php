<?php

namespace App\Http\Requests;

use App\Models\Page;
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
        $is_prev_edit = request()->route()->action['as'] == 'page.onEdit.order';
        //keys form orders array from above route are pages' ids

        if($is_prev_edit) {
            $size = $this->chapter->pages->count();
        } else {
            $size = count(Storage::disk('temp')->allFiles($this->manga->id));  //qty_temp_files
        }

        return [
            'orders' => [
                'array',
                'required',
                "size:$size",
                function($attr, $value, $fail) use($size, $is_prev_edit) {   //validating array keys
                    if(!Page::checkOrders(orders: $value, max: $size)
                        && !$is_prev_edit)
                        return $fail("$attr' keys are invalid");
                }
            ],
            'orders.*' => "distinct|required|numeric|min:1|max:$size"
        ];
    }

    public function messages()
    {
        return [
            'orders.*.distinct' => 'Pages cannot have the same order.'
        ];
    }
}
