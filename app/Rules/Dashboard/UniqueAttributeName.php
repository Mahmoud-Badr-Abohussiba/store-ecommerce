<?php

namespace App\Rules\Dashboard;

use App\Models\AttributeTranslation;
use Illuminate\Contracts\Validation\Rule;

class UniqueAttributeName implements Rule
{
    private $name;
    private $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($name, $id)
    {
       $this->name = $name;
       $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // $attribute = 'name'
        if ($attributeTranslation = AttributeTranslation::where($attribute, $value)->first())
               { if ($attributeTranslation->attribute_id == $this->id) return true;
                 else return false;
               }
        else
            return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'هذا الاسم موجود بالفعل';
    }
}
