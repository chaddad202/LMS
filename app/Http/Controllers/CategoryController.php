<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Course_category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|Integer|exists:categories,id',
            'course_id' => 'required|Integer|exists:courses,id'
        ]);
        $data = Course_category::create([
            'course_id' => $request->course_id,
            'category_id' => $request->category_id,
        ]);
        return response([
            'Data' => $data,

        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $request->validate(['category_id' => 'required|Integer|exists:categories,id']);
        $category = Category::find($request->category_id);
        $courses = $category->courses;
        return response([
            'category' => $category,
            'courses' => $courses
        ], 200);
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
    public function update(Request $request, $course_id_old, $category_id_old)
    {
        $request->validate([
            'category_id' => 'required|Integer|exists:categories,id',
            'course_id' => 'required|Integer|exists:courses,id'
        ]);
        $data = $request->all();
        $course_category = Course_category::where('category_id', $request->category_id_old &&  'course_id', $request->course_id_old);
        $course_category->update($data);
        return response([
            'Data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'category_id' => 'required|Integer|exists:categories,id',
            'course_id' => 'required|Integer|exists:courses,id'
        ]);
        $data = $request->all();
        $course_category = Course_category::where('category_id', $request->category_id &&  'course_id', $request->course_id);
        $course_category->update($data);
        return response([
            "Deleted susseccfully"
        ]);
    }
}
