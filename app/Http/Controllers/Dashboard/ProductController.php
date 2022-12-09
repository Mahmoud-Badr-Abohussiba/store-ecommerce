<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {

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

        return $request;
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
