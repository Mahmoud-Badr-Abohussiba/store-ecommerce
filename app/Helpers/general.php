<?php

define('PAGINATION_COUNT',15);

function getCssFolder()
{
    return app()->getLocale()==='ar'?'css-rtl':'css';
}

function uploadImage($folder,$image){
    \Illuminate\Support\Facades\Storage::disk($folder)->put('/',$image);
    $filename = $image->hashName();
    return $filename;
}

function deleteImage($folder,$image){
    \Illuminate\Support\Facades\Storage::disk($folder)->delete('/'.$image);

}
