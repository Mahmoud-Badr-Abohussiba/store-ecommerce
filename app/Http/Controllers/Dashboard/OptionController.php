<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\OptionRequest;
use App\Models\Attribute;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = Option::with(['attribute'=>function($attribute){
            $attribute->select('id');
        }
            ,'product'=>function($product){
                $product->select('id');
            }])->get()->sortByDesc('id');
        if(!$options->count()==0)
            $options =  $options->toQuery()->paginate(PAGINATION_COUNT);

        return view('dashboard.products.options.index', compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products  = Product::active()->select('id')->get();
        $attributes = Attribute::select('id')->get();
        return view('dashboard.products.options.create',compact('products','attributes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(OptionRequest $request)
    {

        try {
            DB::beginTransaction();
            $option = Option::create([
                'price'=>$request->price,
                'product_id'=>$request->product_id,
                'attribute_id'=>$request->attribute_id,
            ]);
            $option->name = $request->name;
            $option->save();
            DB::commit();
            return redirect()->route('options.index')->with(['success' => 'تم الاضافه بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('options.index')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $option = Option::find($id);

        if (!$option)
            return redirect()->route('options.index')->with(['error' => 'هذه الماركة غير موجوده']);

        $products  = Product::active()->select('id')->get();
        $attributes = Attribute::select('id')->get();

        return view('dashboard.products.options.edit', compact('option','products','attributes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(OptionRequest $request, $id)
    {
        $option = Option::find($id);

        if (!$option)
            return redirect()->route('product.index')->with(['error' => 'هذه الماركة غير موجوده']);

        try {
            DB::beginTransaction();
            $option->update($request->only(['product_id','attribute_id','price']));
            $option ->name = $request->name;
            $option ->save();
            DB::commit();

            return redirect()->route('options.index')->with(['success' => 'تم الاضافه بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('options.index')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
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
//        $option = Option::find($id);
//        if (!$option)
//            return redirect()->route('options.index')->with(['error' => 'هذه الماركة غير موجوده']);
//        else {
//            $option->delete();
//            return redirect()->route('options.index')->with(['success' => 'تم الحذف بنجاح']);
//        }
    }
}
