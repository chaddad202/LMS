<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\GeneralTrait;
use App\Models\Course;
use App\Models\Course_category;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return response([
            'data' => $courses
        ], 200);
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
    public function store(CourseRequest $request)
    {

        $data = $request->all();
        $photo  = '';
        if ($request->hasFile('photo')) {
            $photo  = $request->file('photo')->store('public/images');
        }
        $data['photo'] = $photo;
        $course = Course::create($data);
        $key = 'Data';

        return $this->returnData($key, $course, $msg = 'Successfully ');
    }

    /**
     * Display the specified resource.
     */
    public function teacher_courses(Request $request)
    {
        $request->validate(["user_id" => "required|Integer|exists:users,id"]);
        $teacher = User::find($request->user_id);
        $courses = $teacher->courses->all();
        $key = 'data';

        if (!$courses) {
            return response([
                'message' => 'no course yet'
            ], 200);
        }
        return $this->returnData($key, $courses, $msg = 'Successfully ');
    }
    public function show(Request $request)
    {
        $request->validate(["course_id" => "required|Integer|exists:courses,id"]);
        $course = Course::find($request->course_id);
        $teacher = $course->user;
        $category = $course->categories;
        return response([
            'course_data' => $course,
            'teacher' => $teacher,

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
    public function update(CourseUpdateRequest $request)
    {
        $teacher = User::find($request->user_id);
        $course = Course::find($request->id);
        $data = $request->all();
        if ($request->hasFile('photo')) {
            Storage::delete($course->photo);
            $photo  = $request->file('photo')->store('public/images');
            $data['photo'] = $photo;
        }
        $course->update($data);
        $key = "data";



        return $this->returnData($key, $course, $msg = 'Successfully ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id'  => 'required|Integer|exists:courses,id',
            'user_id' => 'required|Integer|exists:users,id',
        ]);
        $course = Course::find($request->id);
        $course->delete();
        return response([
            "DELETED SUCCESSFULLY"
        ], 200);
    }
    public function search(Request $request)
    {
        $searchcourse = $request->validate(['title' => 'required']);
        $course = Course::where('title', 'like', '%' . $searchcourse['title'] . '%')->get();
        if (!count($course) == 0) {
            return $course;
        } else {
            return response(["message" => "medic not found"]);
        }
    }
}
