<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateRequest;
use App\Http\Resources\FilteringResource;
use App\Models\Rate;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RateController extends Controller
{
    use GeneralTrait;
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
    public function store(RateRequest $request, $course_id)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        $isEnrolled = $user->enrollments()->where('course_id', $course_id)->exists();

        if (!$isEnrolled) {
            return $this->returnError(304, 'You should enroll first');
        }

        $existingRate = Rate::where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->first();

        if ($existingRate) {
            return $this->returnError(304, 'You have already rated this course');
        }

        Rate::create([
            'user_id' => $user_id,
            'course_id' => $course_id,
            'value' => $request->value
        ]);

        return $this->returnSuccessMessage('Created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rate = [];
        if ($id == 1) {
            $rate = Course::with(['user'])
                ->leftJoin('rates', 'courses.id', '=', 'rates.course_id')
                ->select('courses.*', DB::raw('AVG(rates.value) as average_rating'))
                ->groupBy('courses.id', 'courses.title', 'courses.photo', 'courses.category_id', 'courses.description', 'courses.coupon_id', 'courses.price', 'courses.level', 'courses.user_id', 'courses.course_duration', 'courses.created_at', 'courses.updated_at')
                ->having(DB::raw('AVG(rates.value)'), '>=', 4.5)
                ->orderByDesc(DB::raw('AVG(rates.value)'))->get();
        } else  if ($id == 2) {
            $rate =  Course::with(['user'])
                ->leftJoin('rates', 'courses.id', '=', 'rates.course_id')
                ->select('courses.*', DB::raw('AVG(rates.value) as average_rating'))
                ->groupBy('courses.id', 'courses.title', 'courses.photo', 'courses.category_id', 'courses.description', 'courses.coupon_id', 'courses.price', 'courses.level', 'courses.user_id', 'courses.course_duration', 'courses.created_at', 'courses.updated_at')
                ->having(DB::raw('AVG(rates.value)'), '>=', 4.0)
                ->orderByDesc(DB::raw('AVG(rates.value)'))->get();
        } else  if ($id == 3) {
            $rate =  Course::with(['user'])
                ->leftJoin('rates', 'courses.id', '=', 'rates.course_id')
                ->select('courses.*', DB::raw('AVG(rates.value) as average_rating'))
                ->groupBy('courses.id', 'courses.title', 'courses.photo', 'courses.category_id', 'courses.description', 'courses.coupon_id', 'courses.price', 'courses.level', 'courses.user_id', 'courses.course_duration', 'courses.created_at', 'courses.updated_at')
                ->having(DB::raw('AVG(rates.value)'), '>=', 3.5)
                ->orderByDesc(DB::raw('AVG(rates.value)'))->get();
        } else  if ($id == 4) {
            $rate =  Course::with(['user'])
                ->leftJoin('rates', 'courses.id', '=', 'rates.course_id')
                ->select('courses.*', DB::raw('AVG(rates.value) as average_rating'))
                ->groupBy('courses.id', 'courses.title', 'courses.photo', 'courses.category_id', 'courses.description', 'courses.coupon_id', 'courses.price', 'courses.level', 'courses.user_id', 'courses.course_duration', 'courses.created_at', 'courses.updated_at')
                ->having(DB::raw('AVG(rates.value)'), '>=', 3.0)
                ->orderByDesc(DB::raw('AVG(rates.value)'))->get();
        }
        $numberOfCourses = $rate->count();

        return response()->json([
            'number_courses' => $numberOfCourses,
            'courses' => FilteringResource::collection($rate),
        ]);    }

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
    public function update(RateRequest $request, $rate_id)
    {
        $rate = Rate::find($rate_id);
        $rate->update($request->all());
        return $this->returnSuccessMessage('updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($rate_id)
    {
        $rate = Rate::find($rate_id);
        $rate->delete();
        $course = course::findOrFail($rate->course_id);
        $course->number_of_rating -= 1;
        $rating =  Rate::where('course_id', $rate->course_id)->get();
        $value = 0;
        foreach ($rating->value as $ratings) {
            $value += $ratings;
        }
        $course->rating = $value / $course->number_of_rating;
        return $this->returnSuccessMessage('deleted successfully');
    }
}
