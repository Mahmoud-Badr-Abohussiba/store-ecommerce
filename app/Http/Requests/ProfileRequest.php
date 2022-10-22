<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name'=>'required',
           'email' => 'required|email|unique:admins,email,'.$this->id,
            'password'=>'nullable|confirmed|min:8'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'يجب ادخال الايميل',
            'email.email' => 'صيغه الايميل غير صحيحه',
            'name.required' => 'يجب ادخال الاسم',
            'password.confirmed' => 'كلمة المرور غير متطابقه'
        ];
    }
}
