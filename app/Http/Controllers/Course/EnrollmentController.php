<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\enrollment\EnrollmentRequest;
use App\Http\Resources\enrollment\EnrollmentIndexAResource;
use App\Http\Resources\enrollment\EnrollmentIndexResource;
use App\Http\Resources\enrollment\EnrollmentIndexSResource;
use App\Http\Resources\enrollment\EnrollmentIndexTResource;
use App\Http\Resources\enrollment\EnrollmentShowIndex;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Course_skills;
use App\Models\Gift;
use App\Models\User;
use App\Models\User_skill;
use App\Traits\GeneralTrait;

class EnrollmentController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user = User::find(auth()->user()->id);
        // if ($user->hasRole('teacher')) {
        //     $course =Course::where('user_id', $user->id)->get();
        //         $enrollment = Enrollment::where('course_id', $course->pluck('id'))->get();
        //     return EnrollmentIndexTResource::collection($enrollment);
        // } else if ($user->hasRole('student')) {
        //     $enrollment = Enrollment::where('user_id', $user)->get();
        //     return EnrollmentIndexSResource::collection($enrollment);
        // } else if ($user->hasRole('admin')) {
        //     $enrollment = Enrollment::all();
        //     return EnrollmentIndexAResource::collection($enrollment);
        // }
        $enrollment = Enrollment::all();
        //return response()->json([$enrollment]);
        return response([
            'enrollment' => $enrollment
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
    public function store(EnrollmentRequest $request, $course_id)
    {
        $user_id = auth()->user()->id;
        $course = Course::findOrFail($course_id);
        $teacher_id = $course->user_id;
        $teacher = User::findOrFail($teacher_id);
        $user = User::findOrFail($user_id);
        $enrollment = Enrollment::where('user_id', $user_id)->where('course_id', $course->id)->first();
        $price = $course->price;

        if ($user_id == $teacher_id) {
            return $this->returnError(304, 'You cannot enroll in your own course.');
        }

        if ($enrollment) {
            return $this->returnError(304, 'You are already enrolled.');
        }

        // Check if it's a gift enrollment
        if ($request->has('user_id')) {
            $gift = Gift::where('giftedUser_id', $user_id)
                ->where('course_id', $course_id)
                ->where('user_id', $request->user_id)
                ->first();

            if ($gift) {
                Enrollment::create([
                    'user_id' => $user_id,
                    'course_id' => $course->id,
                    'totalPayment' => $price,
                    'progress' => $request->progress
                ]);
                $gift->delete();
                return $this->returnSuccessMessage('Enrolled successfully via gift.');
            }

            return $this->returnError(404, 'Gift not found.');
        }

        // Check if a coupon is applied
        if ($request->has('coupon_code')) {
            $coupon = $course->coupon;

            if ($coupon && $coupon->coupon_code == $request->coupon_code) {
                $price *= (1 - $coupon->discount / 100); // Assuming discount is a percentage
            } else {
                return $this->returnError(403, 'Incorrect coupon code.');
            }
        }

        // Check if the user has enough wallet balance
        if ($user->wallet >= $price) {
            Enrollment::create([
                'user_id' => $user_id,
                'course_id' => $course->id,
                'totalPayment' => $price,
                'progress' => $request->progress
            ]);

            // Update the teacher's and user's wallet
            $teacher->wallet += $price;
            $teacher->save();
            $user->wallet -= $price;
            $user->save();

            // Add skills to the user
            foreach ($course->skills as $skill) {
                User_skill::create([
                    'user_id' => $user_id,
                    'skills_id' => $skill->id,
                    'point' => $skill->point
                ]);
            }

            return $this->returnSuccessMessage('Enrolled successfully.');
        }

        return $this->returnError(304, 'Insufficient funds to enroll.');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $enrollment = Enrollment::find($id);
        $enrollment->delete();
    }
}
