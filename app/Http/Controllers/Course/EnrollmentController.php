<?php

namespace App\Http\Controllers\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\enrollment\EnrollmentRequest;
use App\Http\Resources\enrollment\EnrollmentIndexResource;
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
        $user2 = auth()->user()->id;
        $user = User::find($user2);
        $enrollment = Enrollment::where('user_id', $user2)->get();
        return EnrollmentIndexResource::collection($enrollment);
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
        $data = $request->all();
        $user = auth()->user()->id;
        $course = Course::findOrFail($course_id);
        $enrollment = Enrollment::where('user_id', $user)->where('course_id', $course->id)->first();
        if (!$enrollment) {
            Enrollment::create([
                'user_id' => $user,
                'course_id' => $course->id,
                'totalPayment' => $request->totalPayment,
                'progress' => $request->progress
            ]);
            return $this->returnSuccessMessage('created successfully');
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
