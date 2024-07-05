<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\course\CourseRequest;
use App\Http\Requests\course\CourseUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\GeneralTrait;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\course\CourseIndexResource;
use App\Http\Resources\course\CourseShowResource;
use App\Http\Resources\ShowEnrollmentResoursce;
use App\Models\Skills;

class CourseController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return CourseIndexResource::collection($courses);
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

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $request->photo,
            'price'  => $request->price,
            'level' => $request->level
        ];
        $user = auth()->user()->id;
        $data['user_id'] = $user;
        $photo  = '';
        if ($request->hasFile('photo')) {
            $photo  = $request->file('photo')->store('public/images');
        }
        $data['photo'] = $photo;
        $course = Course::create($data);
        foreach ($request->category as $categories) {
            $course->categories()->attach($categories['id']);
        }
        foreach ($request->skills as $skill) {
            $s = Skills::where('id', $skill['id'])->first();
            if ($skill['point'] > $s->maximunPoint) {
                return $this->returnError(304, " the maximun is = $s->maximunPoint");
            }
            $course->skills()->attach($skill['id'], ['point' => $skill['point']]);
        }


        return $this->returnSuccessMessage('created successfully');
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
            return $this->returnSuccessMessage('no courses yet');
        }
        return $this->returnData($key, $courses, $msg = 'Successfully ');
    }
    public function show($id)
    {
        $course = Course::find($id);
        return new CourseShowResource($course);
    }
    public function showEnrollment()
    {
        $user = auth()->user()->id;
        $course = Course::where('user_id', $user)->get();
        return new ShowEnrollmentResoursce($course);
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
    public function update(CourseUpdateRequest $request, $id)
    {

        $course = Course::findOrfail($id);
        $user = auth()->user()->id;
        if ($user == $course->user_id) {
            $data = $request->all();
            if ($request->hasFile('photo')) {
                Storage::delete($course->photo);
                $photo  = $request->file('photo')->store('public/images');
                $data['photo'] = $photo;
            }
            $course->update($data);
            $key = "data";
            return $this->returnSuccessMessage($msg = ' updated Successfully ');
        }
        return $this->returnError(401, 'Unauthenticated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        $user = auth()->user()->id;
        if ($user == $course->user_id) {
            $course->delete();
            return $this->returnSuccessMessage($msg = ' deleted Successfully ');
        }
        return $this->returnError(401, 'Unauthenticated');
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
