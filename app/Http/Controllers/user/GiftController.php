<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\gift\GiftRequest;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Gift;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\GeneralTrait;

class GiftController extends Controller
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
    public function store(GiftRequest $request, $course_id)
    {
        $course = Course::findOrfail($course_id);
        $teacher = $course->user;
        $user_id = auth()->user()->id;
        $user = User::findOrFail($user_id);
        $enrollment =Enrollment::where('user_id', $user_id)->where('course_id',$course_id)->first();
        if ($user &&$enrollment) {

            Gift::create([
                'user_id' => $user_id,
                'giftedUser_id' => $request->giftedUser_id,
                'course_id' => $course_id
            ]);
            $enrollment->delete();
            return $this->returnSuccessMessage('created successfully');
        }
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
