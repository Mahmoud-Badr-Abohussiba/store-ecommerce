<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'type'=>'in:main,sub',
            'name'=>'required',
            'slug' => 'required|unique:categories,slug,'.$this->id,
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'يرجى ادخال الاسم',
            'slug.required'=>'يرجى ادخال الرابط',
            'slug.unique'=>'موجود بالفعل',
        ];
    }
}
