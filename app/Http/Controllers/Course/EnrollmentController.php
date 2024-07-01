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
use App\Models\User;
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

        $user = auth()->user()->id;
        $course = Course::findOrFail($course_id);
        $enrollment = Enrollment::where('user_id', $user)->where('course_id', $course->id)->first();
        if (!$enrollment) {
            if ($request->totalPayment == $course->price) {
                Enrollment::create([
                    'user_id' => $user,
                    'course_id' => $course->id,
                    'totalPayment' => $request->totalPayment,
                    'progress' => $request->progress
                ]);
                return $this->returnSuccessMessage('created successfully');
            }
            return $this->returnError(304, "you should pay $course->price");
        }
        return $this->returnError(304, 'you are already enrollment');
    }
    /**
     * Display the specified resource.
     */
    public function show($course_id)
    {
        $enrollment = Enrollment::where('course_id', $course_id)->get();

        return  EnrollmentShowIndex::collection($enrollment);
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
    public function destroy(string $id)
    {
        //
    }
}
