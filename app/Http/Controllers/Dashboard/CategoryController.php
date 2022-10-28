<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index($type)
    {
        switch ($type) {
            case 'main':
                $categories = Category::parent()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
                return view('dashboard.categories.index', compact('categories', 'type'));
                break;
            case 'sub':
                $categories = Category::child()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
                return view('dashboard.categories.index', compact('categories', 'type'));
                break;
            default :
                return redirect()->back()->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }

    }

    public function create($type)
    {
        switch ($type) {
            case 'main':
                return view('dashboard.categories.create', compact('type'));
                break;
            case 'sub':
                $categories = Category::parent()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
                return view('dashboard.categories.create', compact('type', 'categories'));
                break;
            default :
                return redirect() - back()->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }

    public function store(CategoryRequest $request, $type)
    {
        switch ($type) {
            case 'main':
                break;
            case 'sub':
                $request->validate([
                    'parent_id' => 'required|exists:categories,id'
                ]);
                break;
            default:
                return redirect()->back()->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }

        try {
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);


            DB::beginTransaction();
            $category = Category::create([
                'slug' => $request->slug,
                'is_active' => $request->is_active,
                'parent_id' => $request->parent_id,
            ]);
            $category->name = $request->name;
            $category->save();
            DB::commit();
            return redirect()->route('admin.categories', $type)->with(['success' => 'تم الاضافه بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.categories', $type)->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);

        if (!$category)
            return redirect()->route('admin.categories')->with(['error' => 'هذا القسم غير موجود']);

        $categories = Category::parent()->orderBy('id', 'DESC')->get();

        return view('dashboard.categories.edit', compact('category', 'categories'));
    }

    public function update(CategoryRequest $request, $id)
    {

        $category = Category::find($id);
        if (!$category)
            return redirect()->route('admin.categories')->with(['error' => 'هذا القسم غير موجود']);

        switch ($request->type) {
            case 'main':
                break;
            case 'sub':
                if ($request->has('parent_id')) {
                    $request->validate(['parent_id' => 'exists:categories,id']);
                } else {
                    $request->request->add(['parent_id' => $category->parent_id, 'type' => 'main']);
                }
                break;
            default:
                return redirect()->back()->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }

        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => $category->is_active]);

        try {

            DB::beginTransaction();
            $category->update($request->only(['slug', 'is_active', 'parent_id']));
            $category->name = $request->name;
            $category->save();
            DB::commit();

            return redirect()->route('admin.categories', $request->type)->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.categories', $request->type)->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }

    }

    public function destroy($id, $type)
    {
        if ($type == 'sub' | $type == 'main') {
            $category = Category::find($id);
            if (!$category)
                return redirect()->route('admin.categories', $type)->with(['error' => 'هذا القسم غير موجود']);

            try {
                $category->delete();
                return redirect()->route('admin.categories', $type)->with(['success' => 'تم الحذف بنجاح']);
            } catch (\Exception $ex) {
                return redirect()->route('admin.categories', $type)->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
            }

        } else {
            return redirect()->back()->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }

}
