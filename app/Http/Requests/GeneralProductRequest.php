<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneralProductRequest extends FormRequest
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
        $slug = $this->route()->parameter('slug');  // use when update
        return [
            'name' => 'required|max:100',
            'slug' => ['min:1|unique:products,slug,' . $slug,],
            'description' => 'required|max:10000',
            'short_description' => 'nullable|max:500',
            'categories' => 'required|array|min:1',
            'categories.*' => 'required|exists:categories,id',
            'tags' => 'nullable|array|min:1',
            'tags.*' => 'numeric|exists:tags,id',
            'brand_id' => 'nullable|exists:brands,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'يرجى ادخال الاسم',
            'slug.min' => 'يرجى ادخال الاسم الرابط',
            'slug.unique' => 'موجود بالفعل',
            'categories.*.required'=>'يرجى ادخال القسم'
        ];
    }
}
