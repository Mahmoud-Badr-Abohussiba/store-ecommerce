<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ShippingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function editShippingMethod($type){
        // free , inner , outer for shipping methods
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

            DB::beginTransaction();
            $shipping_method-> update(['plain_value'=>$request->plain_value,]);

            // save translation
            $shipping_method-> value = $request-> value;
            $shipping_method->save();

            DB::commit();
            return redirect()->back()->with(['success'=>'تم التحديث بنجاح']);
        }catch (\Exception $ex){
            return redirect()->back()->with(['error'=>'هناك خطأ يرجى المحاوله فيما بعد']);
            DB::rollBack();
        }

    }
}
