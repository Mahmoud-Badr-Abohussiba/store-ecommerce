<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralProductRequest;
use App\Http\Requests\ProductImagesRequest;
use App\Http\Requests\ProductPriceValidation;
use App\Http\Requests\ProductStockRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all()->sortByDesc('id')->toQuery()->paginate(PAGINATION_COUNT);
        return view('dashboard.products.general.index', compact('products'));
    }

    public function show()
    {

    }

    public function create()
    {
        $data = [
            'brands' => Brand::active()->orderBy('id', 'DESC')->get(),
            'categories' => Category::active()->orderBy('id', 'DESC')->get(),
            'tags' => Tag::query()->orderBy('id', 'DESC')->get(),
        ];

        return view('dashboard.products.general.create', compact('data'));
    }

    public function store(GeneralProductRequest $request)
    {

        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);
        try {
            DB::beginTransaction();
            $product = Product::create([
                'slug' => Str::slug($request->input('name') . Str::random(5), '-'),
                'name' => $request->name,
                'is_active' => $request->is_active,
                'brand_id'=>$request->brand_id,
            ]);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->save();

            $product->categories()->attach($request->categories);
            $product->tags()->attach($request->tags);

            DB::commit();

            return redirect()->route('admin.products')->with(['success' => 'تم الاضافه بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.products')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }

    public function getPrice($product_id){
        $product = Product::query()->where('id',$product_id)->first();
//        dd($product);
        return view('dashboard.products.prices.create',compact('product'));
    }

    public function saveProductPrice(ProductPriceValidation $request){

        try{

           Product::whereId($request -> product_id) -> update($request -> only(['price','special_price','special_price_type','special_price_start','special_price_end']));

            return redirect()->route('admin.products')->with(['success' => 'تم التحديث بنجاح']);
        }catch(\Exception $ex){
            return redirect()->route('admin.products')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }

    public function getStock($product_id){
        $product = Product::whereId($product_id)->first();
        return view('dashboard.products.stock.create') -> with('product',$product) ;
    }

    public function saveProductStock(ProductStockRequest $request){

        try{
        Product::whereId($request -> product_id) -> update($request -> except(['_token','product_id']));

        return redirect()->route('admin.products')->with(['success' => 'تم التحديث بنجاح']);
        }catch(\Exception $ex){
            return redirect()->route('admin.products')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }

    public function addImages($product_id){
        $product = Product::whereId($product_id)->first();
        return view('dashboard.products.images.create')->with('product',$product);
    }

    //to save images to folder only
    public function saveProductImages(Request $request ){

        $file = $request->file('dzfile');
        $filename = uploadImage('products', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);

    }

    public function saveProductImagesDB(ProductImagesRequest $request){

        try {
//             save dropzone images
            if ($request->has('document') && count($request->document) > 0) {
                foreach ($request->document as $image) {
                    Image::create([
                        'product_id' => $request->product_id,
                        'photo' => $image,
                    ]);
                }
            }

            return redirect()->route('admin.products')->with(['success' => 'تم التحديث بنجاح']);

        }catch(\Exception $ex){
            return redirect()->route('admin.products')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }


    public
    function edit()
    {

    }

    public
    function update()
    {

    }

    public
    function destroy()
    {

    }
}
