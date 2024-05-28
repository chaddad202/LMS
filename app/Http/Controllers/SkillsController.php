<?php

namespace App\Http\Controllers;

use App\Models\Course_skills;
use App\Models\Skills;
use Illuminate\Http\Request;
use App\Models\Course;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
            'course_id' => "required|Integer|exists:courses,id",
            'skill' => 'required|string',
        ]);
        $course = Course::find($request->course_id);
        $user = $course->user;
        $user_id = $user->id;
        $authLesson = auth()->user()->id;
        if ($authLesson == $user_id) {

            $skill = Skills::create(['skill' => $request->skill]);
            $Course_skills = Course_skills::create([
                'course_id' => $request->course_id,
                'skill_id' => $skill->id
            ]);
            return response([
                'message' => 'created successfuly'
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
        $request->validate([
            'course_id' => "required|Integer|exists:courses,id",
        ]);
        $course = Course::find($request->course_id);
        $Course_skills = Course_skills::where('course_id', $request->course_id)->get();
        $skill_id  = $Course_skills->pluck("skill_id");
        $skill = Skills::find($skill_id);


        return response([
            'Data' =>
            $skill
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
    public function update(Request $request)
    {
        $request->validate([
            'skill_id' => "required|Integer|exists:skills,id",
            'course_id' => "required|Integer|exists:courses,id",
            'skill' => 'required|string',

        ]);
        $course = Course::find($request->course_id);
        $user = $course->user;
        $user_id = $user->id;
        $authLesson = auth()->user()->id;
        if ($authLesson == $user_id) {
            $skill = Skills::find($request->skill_id);
            $skill->update(['skill' => $request->skill]);
            return response([
                'message' => 'updated successfuly'
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
            'skill_id' => "required|Integer|exists:skills,id",
            'course_id' => "required|Integer|exists:courses,id",
        ]);
        $course = Course::find($request->course_id);
        $user = $course->user;
        $user_id = $user->id;
        $authLesson = auth()->user()->id;
        if ($authLesson == $user_id) {
            $skill = Skills::find($request->skill_id);
            $skill->delete();
            return response([
                'message' => 'deleted successfuly'
            ], 200);
            return response([
                'YOU ARE NOT THE SAME TEACHER'
            ], 403);
        }
    }
}
