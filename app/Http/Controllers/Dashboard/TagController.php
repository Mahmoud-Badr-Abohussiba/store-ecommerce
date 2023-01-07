<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags= Tag::all()->sortByDesc('id')->toQuery()->paginate(PAGINATION_COUNT);
        return view('dashboard.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        try {
            DB::beginTransaction();
            $tag = Tag::create([
                'slug' => Str::slug($request->input('name').Str::random(5), '-'),
            ]);
            $tag->name = $request->name;
            $tag->save();
            DB::commit();

            return redirect()->route('admin.tags')->with(['success' => 'تم الاضافه بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.tags')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $tag = Tag::query()->where('slug',$slug)->first();

        if (!$tag)
            return redirect()->route('admin.tags')->with(['error' => 'هذا الشعار غير موجود']);

        return view('dashboard.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $slug)
    {
        $tag = Tag::query()->where('slug',$slug)->first();

        if (!$tag)
            return redirect()->route('admin.tags')->with(['error' => 'هذا الشعار غير موجود']);


        try {
            DB::beginTransaction();
            $tag->update([
                'slug' => $request->slug,
            ]);
            $tag->name = $request->name;
            $tag->save();
            DB::commit();

            return redirect()->route('admin.tags')->with(['success' => 'تم الاضافه بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.tags')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $tag = Tag::query()->where('slug',$slug)->first();
        if (!$tag)
            return redirect()->route('admin.tags')->with(['error' => 'هذا الشعار غير موجود']);
        try {
            $tag->delete();
            return redirect()->route('admin.tags')->with(['success' => 'تم الحذف بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.tags')->with(['error' => 'هناك خطأ ما يرجى المحاوله فيما بعد']);
        }
    }
}
