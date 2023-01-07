<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use Translatable;

    protected $fillable= ['attribute_id', 'product_id','price'];

    /**
     * The relation to eager load on every query.
     *@var array
     */

    protected $with = ['translations'];

    protected $translatedAttributes = ['name'];

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
