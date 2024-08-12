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
use App\Http\Resources\FilteringResource;
use App\Http\Resources\ShowEnrollmentResoursce;
use App\Models\Coupon;
use App\Models\Information;
use App\Models\Skills;
use App\Models\Gain_prequist;

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
        $user = auth()->user()->id;
        $coupon = Coupon::findOrFail($request->coupon_id);
        if ($user != $coupon->user_id) {
            return response(['message' => 'not authountcated'], 401);
        }
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $request->photo,
            'price'  => $request->price,
            'level' => $request->level,
            'category_id' => $request->category_id,
            'coupon_id' => $request->coupon_id,
        ];
        $data['user_id'] = $user;
        $photo  = '';
        if ($request->hasFile('photo')) {
            $photo  = $request->file('photo')->store('public/images');
        }
        $data['photo'] = $photo;
        $course = Course::create($data);
        $course_level = $request->level;
        foreach ($request->skills as $skill) {
            $s = Skills::where('id', $skill['id'])->first();
            $point_max = 0;
            $point_min = 0;
            if ($course_level == 'beginner') {
                $point_max = $s->maximunBeginner;
            } else if ($course_level == 'intemediate') {
                $point_max = $s->maximunIntemediate;
                $point_min = 26;
            } else {
                $point_max = $s->maximunAdvanced;
                $point_min = 76;
            }
            if ($skill['point'] > $point_max) {
                return $this->returnError(304, " the maximun for $s->title = $point_max");
            } else if ($skill['point'] < $point_min) {
                return $this->returnError(304, " the min for $s->title = $point_min");
            }
            $course->skills()->attach($skill['id'], ['point' => $skill['point']], ['status' => $skill['status']]);
        }
        foreach ($request->gain_prequist as $gain_prequists) {
            Gain_prequist::create([
                'text' => $gain_prequists['text'],
                'status' => $gain_prequists['status'],
                'course_id' => $course->id
            ]);
        }


        return $this->returnSuccessMessage('created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function teacher_courses($id)
    {
        $user = User::findOrFail($id);
        $courses =  Course::where('user_id', $id)->get();
        if ($courses->isEmpty()) {
            return response(['message' => 'not found'], 404);
        }
        return FilteringResource::collection($courses);
    }
    public function show($id)
    {
        $course = Course::findOrFail($id);
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
        if ($request->all() === null || count($request->all()) === 0) {
            return response(['message' => 'request is empty'], 403);
        }
        $user = auth()->user()->id;
        $user_auth = User::find($user);
        if ($user == $course->user_id || $user_auth->hasRole('admin')) {
            $data = $request->all();
            if ($request->hasFile('photo')) {
                Storage::delete($course->photo);
                $photo  = $request->file('photo')->store('public/images');
                $data['photo'] = $photo;
            }
            if ($request->has('coupon_id')) {
                $coupon = Coupon::findOrFail($request->coupon_id);
                if ($user != $coupon->user_id) {
                    return $this->returnError(304, 'Unauthenticated');
                }
            }
            $course->update($data);
            return $this->returnSuccessMessage(' updated Successfully ');
        }
        return response(['message' => 'not authountcated'], 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $user = auth()->user()->id;

        $user_auth = User::find($user);
        if ($user == $course->user_id || $user_auth->hasRole('admin')) {
            Storage::delete($course->photo);
            $course->delete();
            return $this->returnSuccessMessage($msg = ' deleted Successfully ');
        }
        return response(['message' => 'not authountcated'], 401);
    }
    public function search(Request $request)
    {
        $searchcourse = $request->validate(['title' => 'required']);
        $course = Course::where('title', 'like', '%' . $searchcourse['title'] . '%')->take(12)->get();
        if (!count($course) == 0) {
            return FilteringResource::collection($course);
        } else {
            return response(['message' => 'not found'], 404);
        }
    }
}
