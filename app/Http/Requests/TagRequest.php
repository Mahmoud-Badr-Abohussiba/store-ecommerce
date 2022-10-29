<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
         $slug = $this->route()->parameter('slug');
         return [
             'name'=>'required',
             'slug' => 'min:1|unique:categories,slug,' .$slug,
         ];
     }

    public function messages()
    {
        return [
            'name.required'=>'يرجى ادخال الاسم',
            'slug.min'=>'يرجى ادخال الاسم الرابط',
            'slug.unique'=>'موجود بالفعل',
        ];
    }
}
