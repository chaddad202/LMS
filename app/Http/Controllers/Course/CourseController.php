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
use App\Http\Resources\MyCoursesResource;
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
    public function index(Request $request)
    {
        $query = Course::query();
        $user = auth()->user()->id;

        if ($request->has('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->has('level')) {
            $query->where('level', strtolower($request->input('level')));
        }

        if ($request->has('rating')) {
            $rating = $request->input('rating');
            $query->whereHas('ratings', function ($q) use ($rating) {
                $q->havingRaw('AVG(rating) >= ?', [$rating]);
            });
        }

        if ($request->has('price')) {
            $price = strtolower($request->input('price'));
            if ($price === 'free') {
                $query->where(function ($q) {
                    $q->where('price', 0)
                        ->orWhereNull('price');
                });
            } elseif ($price === 'paid') {
                $query->where('price', '>', 0);
            }
        }

        $courses = $query->get();


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

    $data = [
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $request->photo,
            'price'  => $request->price,
            'level' => $request->level,
            'category_id' => $request->category_id,
            'type' => 'draft'
        ];
        if ($request->has('coupon_id')) {
            $coupon = Coupon::findOrFail($request->coupon_id);
            if ($user != $coupon->user_id) {
                return response(['message' => 'not authountcated'], 401);
            }
            $data['coupon_id'] = $request->coupon_id;
        }
        $data['user_id'] = $user;
        $photo  = '';
        if ($request->hasFile('photo')) {
            $photo  = $request->file('photo')->store('public/images');
        }
        $data['photo'] = $photo;
        Course::create($data);
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
    public function my_courses(){
        $user=User::find(auth()->user()->id);
        $courses=$user->courses;
        return MyCoursesResource::collection($courses);
    }
}
