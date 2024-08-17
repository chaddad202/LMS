<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseSkillRequest;
use App\Http\Requests\CourseSkillUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Course_skills;
use App\Traits\GeneralTrait;

class Course_skillsController extends Controller
{
    use GeneralTrait;
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
    public function store(CourseSkillRequest $request, $course_id)
    {
        $course = Course::find($course_id);
        $user_auth = auth()->user()->id;
        if ($course->user_id != $user_auth) {
            return response(['message' => 'not authountcated'], 401);
        }
        Course_skills::create([
            'course_id' => $course_id,
            'skills_id'=>$request->skills_id,
            'point' => $request->point,
            'status' => $request->status
        ]);
        return $this->returnSuccessMessage('created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(CourseSkillUpdateRequest $request,  $id)
    {
        $course_skill = Course_skills::find($id);
        $user_auth = auth()->user()->id;
        if ($course_skill->user_id != $user_auth) {
            return response(['message' => 'not authountcated'], 401);
        }
        if ($request->all() === null || count($request->all()) === 0) {
            return response(['message' => 'request is empty'], 403);
        }
        $course_skill->update($request->all());
        return $this->returnSuccessMessage('updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $course_skill = Course_skills::find($id);
        $user_auth = auth()->user()->id;
        if ($course_skill->user_id != $user_auth) {
            return response(['message' => 'not authountcated'], 401);
        }
        $course_skill->delete();
        return $this->returnSuccessMessage('deleted successfully');
    }
}
