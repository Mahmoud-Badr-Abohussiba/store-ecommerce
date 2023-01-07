<?php

namespace App\Http\Requests;

use App\Http\Enum\CategoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $slug = $this->route()->parameter('slug');
        return [
            'type'=>[
                Rule::in(CategoryType::mainCategory,CategoryType::subCategory)
            ],
            'name'=>'required',
            'slug' => ['min:1|unique:categories,slug,' .$slug,],
            'photo' => 'required_without:id|mimes:jpg,jpeg,png',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'يرجى ادخال الاسم',
            'slug.min'=>'يرجى ادخال الاسم الرابط',
            'slug.unique'=>'موجود بالفعل',
            'photo.required'=>'يرجى ارفاق الصورة',
            'photo.mimes'=>'صورة غير مناسبة',
        ];
    }
}
