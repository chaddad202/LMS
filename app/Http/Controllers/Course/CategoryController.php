<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\category\CategoryRequest;
use App\Http\Requests\category\CategoryUpdateRequest;
use App\Http\Resources\category\CategoryIndexResource;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Course_category;
use App\Traits\GeneralTrait;

class CategoryController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        return CategoryIndexResource::collection($category);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->all());
        return $this->returnSuccessMessage("created succussefully");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = Category::find($id);
        $category->update($request->all());
        return $this->returnSuccessMessage(' updated succussefully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return $this->returnSuccessMessage(' updated succussefully');
    }
}
