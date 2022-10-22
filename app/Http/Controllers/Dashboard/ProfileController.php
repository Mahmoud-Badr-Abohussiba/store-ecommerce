<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function editProfile(){
        $admin = Admin::find(auth('admin')->user()->id);
        return view('dashboard.profile.edit', compact('admin'));
    }

    public function updateProfile(ProfileRequest $request){
        try {
            $admin = Admin::find(auth('admin')->user()->id);
            if ($request->filled('password')){
//                $request->merge(['password',bcrypt($request->password)]);
                $request['password']=bcrypt($request->password);
                $admin->update($request->only(['name', 'email','password']));
            }else{
                $admin->update($request->only(['name', 'email']));
            }
            return redirect()->route('admin.dashboard')->with(['success'=>'تم التحديث بنجاح']);
        }catch (\Exception $ex){
            return redirect()->back()->with(['error'=>'هناك خطأ يرجى المحاوله فيما بعد']);
        }
    }

}
