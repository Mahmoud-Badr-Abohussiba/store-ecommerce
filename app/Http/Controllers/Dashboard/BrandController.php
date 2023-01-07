<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all()->sortByDesc('id')->toQuery()->paginate(PAGINATION_COUNT);

        return view('dashboard.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {

        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);

        try {

            $photo = $request->file('photo');
            $fileName = '';
            if ($photo) {
                $fileName = uploadImage('brands', $photo);
            }

            DB::beginTransaction();
            $brand = Brand::create([
                'is_active' => $request->is_active,
                'photo' => $fileName,
            ]);
            $brand->name = $request->name;
            $brand->save();
            DB::commit();

            return redirect()->route('admin.brands')->with(['success' => 'تم الاضافه بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.brands')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::find($id);

        if (!$brand)
            return redirect()->route('admin.brands')->with(['error' => 'هذه الماركة غير موجوده']);

        return view('dashboard.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $id)
    {
        $brand = Brand::find($id);

        if (!$brand)
            return redirect()->route('admin.brands')->with(['error' => 'هذه الماركة غير موجوده']);


        if (!$request->has('is_active')) $request->request->add(['is_active' => 0]);
        else $request->request->add(['is_active' => 1]);

        try {
            if ($request->hasFile('photo')) {
                deleteImage('brands', $brand->photo);
                $photo = uploadImage('brands', $request->file('photo'));
            } else $photo = $brand->photo;


            DB::beginTransaction();
            $brand->update([
                'is_active' => $request->is_active,
                'photo' => $photo,
            ]);

            if ($request->has('name')) {
                $brand->name = $request->name;
            }

            $brand->save();
            DB::commit();

            return redirect()->route('admin.brands')->with(['success' => 'تم الاضافه بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.brands')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (!$brand)
            return redirect()->route('admin.brands')->with(['error' => 'هذه الماركة غير موجوده']);

        try {
            deleteImage('brands', $brand->photo);
            $brand->delete();
            return redirect()->route('admin.brands')->with(['success' => 'تم الحذف بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.brands')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }
}
