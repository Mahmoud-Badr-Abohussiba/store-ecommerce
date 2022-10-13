<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function editShippingMethod($type){
       // shipping methods are free , inner , outer
        switch ($type){
            case 'free': {
              $shippingMethod = Setting::where('key','free_shipping_label')->first();
              break;
            }
            case 'inner':{
                $shippingMethod = Setting::where('key','local_shipping_label')->first();
                break;
            }
            case 'outer':{
                $shippingMethod = Setting::where('key','outer_shipping_label')->first();
                break;
            }
        }

       return view('dashboard.settings.shipping methods.edit', compact('shippingMethod'));

    }

    public function updateShippingMethod(ShippingRequest $request, $id)
    {
        try {

            $shipping_method = Setting::find($id);
            $shipping_method-> update(['plain_value'=>$request->plain_value,]);
            $shipping_method-> value = $request-> value;
            $shipping_method->save();

            return redirect()->back()->with(['success'=>'تم التحديث بنجاح']);
        }catch (\Exception $ex){

        }

    }
}
