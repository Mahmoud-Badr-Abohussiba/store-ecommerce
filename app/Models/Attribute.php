<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use Translatable;

    /**
     * The relation to eager load on every query.
     *@var array
     */
    protected $with = ['translations'];

    protected $translatedAttributes = ['name'];

    public function options(){
        return $this->hasMany(Option::class);
    }
}
