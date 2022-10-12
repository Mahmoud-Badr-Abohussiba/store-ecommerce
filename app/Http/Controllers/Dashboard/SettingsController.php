<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function editShippingMethod($type){
       // shipping methods are free , inner , outer
        switch ($type){
            case 'free': {
                $shippingMethod = Setting::where('key','free_shipping_label')->first();
            }
            case 'inner':{
                $shippingMethod = Setting::where('key','local_shipping_label')->first();
            }
            case 'outer':{
                $shippingMethod = Setting::where('key','outer_shipping_label')->first();
            }
        }

        return $shippingMethod;
       // return view('dashboard.settings.shipping methods.edit', compact('shippingMethod'));

    }

    public function updateShippingMethod(Request $request, $id){

    }
}
