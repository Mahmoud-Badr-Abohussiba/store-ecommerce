<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Enum\CategoryType;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index($type = null)
    {
        switch ($type) {
            case CategoryType::mainCategory:
                $categories = Category::parent()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
                return view('dashboard.categories.index', compact('categories', 'type'));
                break;
            case CategoryType::subCategory:
                $categories = Category::child()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
                return view('dashboard.categories.index', compact('categories', 'type'));
                break;
            case null:
            case 'all':
                $categories = Category::query()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
                $type = 'all';
                return view('dashboard.categories.index', compact('categories', 'type'));
                break;
            default :
                return redirect()->back()->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }

    }

    public function create()
    {
        $categories = Category::parent()->orderBy('id', 'DESC')->get();
        return view('dashboard.categories.create', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {

        if($request->has('type')) {
            switch ($request->type) {
                case CategoryType::mainCategory:
                    $request->request->add(['parent_id' => null]);
                    break;
                default :
                    $request->validate(['parent_id' => 'required|exists:categories,id']);
            }
        }

        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);


        try {
            $photo = $request->file('photo');
            $fileName = '';
            if ($photo) {
                $fileName = uploadImage('categories', $photo);
            }

            DB::beginTransaction();

            $category = Category::create([
                'slug' => Str::slug($request->input('name') . Str::random(5), '-'),
                'is_active' => $request->is_active,
                'photo' => $fileName,
                'parent_id' => $request->parent_id,
            ]);
            $category->name = $request->name;
            $category->save();
            DB::commit();


            return redirect()->route('admin.categories')->with(['success' => 'تم الاضافه بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.categories')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }

    public function edit($slug)
    {
        $category = Category::query()->where('slug', $slug)->first();

        if (!$category)
            return redirect()->route('admin.categories')->with(['error' => 'هذا القسم غير موجود']);

        $categories = Category::parent()->orderBy('id', 'DESC')->get();

        return view('dashboard.categories.edit', compact('category', 'categories'));
    }

    public function update(CategoryRequest $request, $slug)
    {

        $category = Category::query()->where('slug', $slug)->first();
        if (!$category)
            return redirect()->route('admin.categories')->with(['error' => 'هذا القسم غير موجود']);

        if($request->has('type')) {
            switch ($request->type) {
                case CategoryType::mainCategory:
                    $request->request->add(['parent_id' => null]);
                    break;
                default :
                    $request->validate(['parent_id' => 'required|exists:categories,id']);
            }
        }

        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => $category->is_active]);

        try {

            if ($request->hasFile('photo')) {
                deleteImage('categories', $category->photo);
                $photo = uploadImage('categories', $request->file('photo'));
            } else $photo = $category->photo;


            DB::beginTransaction();
            $category->update($request->only(['is_active', 'parent_id']));
            $category->update([
                'slug' => $request->slug,
                'photo' => $photo,
            ]);
            $category->name = $request->name;
            $category->save();
            DB::commit();

            return redirect()->route('admin.categories', $request->type)->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.categories', $request->type)->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }

    }

    public function destroy($slug)
    {
            $category = Category::query()->where('slug', $slug)->first();
            if (!$category)
                return redirect()->back()->with(['error' => 'هذا القسم غير موجود']);

            try {
                deleteImage('categories', $category->photo);
                $category->delete();
                return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
            } catch (\Exception $ex) {
                return redirect()->back()->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
            }
    }

}
