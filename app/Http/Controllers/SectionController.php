<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Http\Requests\SectionUpdateRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Section;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'section_id' => 'required|Integer|exists:sections,id',
            'course_id' => 'required|Integer|exists:courses,id',
        ]);
        $course = Course::find($request->course_id);
        $section = $course->sections;
        return response([
            'course' => $course->title,
            'section_of_course' => $section,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request)
    {

        $course = Course::find($request->course_id);
        $user = $course->user;
        $user_id = $user->id;
        $authSection = auth()->user()->id;
        if ($user_id == $authSection) {

            $section = Section::create([
                'course_id' => $request->course_id,
                'title' => $request->title,
                'description' => $request->description,
            ]);
            return response([
                'Data' => $section,
            ], 200);
        }
        return response([
            'YOU ARE NOT THE SAME TEACHER'
        ], 403);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $request->validate(['section_id' => 'required|Integer|exists:sections,id']);
        $section = Section::find($request->section_id);
        $lesson = $section->lessons;
        return response([
            'Data' => $section,
            'lesson_of_section' => $lesson,
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
    public function update(SectionUpdateRequest $request)
    {
        $course = Course::find($request->course_id);
        $user = $course->user;
        $user_id = $user->id;
        $authSection = auth()->user()->id;
        if ($user_id == $authSection) {

            $data = $request->all();

            $section = Section::find($request->section_id);
            $section->update($data);
            return response([
                'message' => "updated successfully",
            ], 200);
        }
        return response([
            'YOU ARE NOT THE SAME TEACHER'
        ], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'course_id' => 'required|Integer|exists:courses,id',
            'section_id' => 'required|Integer|exists:courses,id',
        ]);
        $course = Course::find($request->course_id);
        $user = $course->user;
        $user_id = $user->id;
        $authSection = auth()->user()->id;
        if ($user_id == $authSection) {
            $section = Section::find($request->section_id);
            $section->delete();
            return response([
                'message' => "delete successfully",
            ], 200);
        }

        return response([
            'YOU ARE NOT THE SAME TEACHER'
        ], 403);
    }
}
