<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = Attribute::all()->sortByDesc('id');
        if(!$attributes->count()==0)
            $attributes =  $attributes->toQuery()->paginate(PAGINATION_COUNT);

        return view('dashboard.products.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.products.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeRequest $request)
    {
        try {
            DB::beginTransaction();
            $attribute = Attribute::create([]);
            $attribute->name = $request->name;
            $attribute->save();
            DB::commit();

            return redirect()->route('admin.product.attributes')->with(['success' => 'تم الاضافه بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.product.attributes')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
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
        $attribute = Attribute::find($id);

        if (!$attribute)
            return redirect()->route('admin.product.attributes')->with(['error' => 'هذه الماركة غير موجوده']);

        return view('dashboard.products.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeRequest $request, $id)
    {
        $attribute = Attribute::find($id);

        if (!$attribute )
            return redirect()->route('admin.product.attributes')->with(['error' => 'هذه الماركة غير موجوده']);

        try {
            DB::beginTransaction();
            $attribute ->name = $request->name;
            $attribute ->save();
            DB::commit();

            return redirect()->route('admin.product.attributes')->with(['success' => 'تم الاضافه بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.product.attributes')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
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
        $attribute = Attribute::find($id);
        if (!$attribute)
            return redirect()->route('admin.product.attributes')->with(['error' => 'هذه الماركة غير موجوده']);
        else {
            $attribute->delete();
            return redirect()->route('admin.product.attributes')->with(['success' => 'تم الحذف بنجاح']);
        }
    }
}
