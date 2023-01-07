<?php

namespace App\Http\Requests;

use App\Rules\Dashboard\UniqueAttributeName;
use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
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
         return [
            'name'=>'required|max:100',
            'price'=>'required|numeric|min:0',
            'product_id'=>'required|exists:products,id',
            'attribute_id'=>'required|exists:attributes,id',
         ];
     }

    public function messages()
    {
        return [
            'name.required'=>'يرجى ادخال الاسم',
            'product_id.required'=>'يرجى اختيار منتج',
            'attribute_id.required'=>'يرجى اختيار خاصيه',
        ];
    }
}
