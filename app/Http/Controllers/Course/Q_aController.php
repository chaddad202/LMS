<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Q_aRequest;
use App\Http\Resources\Q_aIndexResource;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Q_a;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use App\Models\User;

class Q_aController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index($lesson_id)
    {
        $user = User::findOrfail(auth()->user()->id);
        $lesson =   Lesson::findOrFail($lesson_id);
        $section = $lesson->section;
        $course = $section->course;
        $enroll = Enrollment::where('course_id', $course->id)->where('user_id', $user->id)->first();
        if (!$enroll) {
            return response(['message' => 'not authountcated'], 401);
        }
        $lesson_qa= $lesson->q_a;
        return Q_aIndexResource::collection($lesson_qa);
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
    public function store(Q_aRequest $request, $id)
    {
        $user = User::find(auth()->user()->id);
        $lesson =   Lesson::findOrFail($id);
        $section = $lesson->section;
        $course = $section->course;
        $enroll = Enrollment::where('course_id', $course->id)->where('user_id', $user->id)->first();
        if (!$enroll) {
            return response([
                'message' => 'not authountcated'
            ], 401);
        }
        $data = ([
            'lesson_id' => $id,
            'comment' => $request->comment,
            'user_id' => auth()->user()->id,
        ]);

        Q_a::create($data);
        return $this->returnSuccessMessage('Created Succussfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($lesson_id)
    {
        $lesson = Lesson::find($lesson_id);
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
    public function update(Q_aRequest $request, $id)
    {

        $comment = Q_a::find($id);
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if ($comment->user_id == $user_id || $user->hasRole('admin')) {
            $comment->update([
                'comment' => $request->comment
            ]);
            return $this->returnSuccessMessage("updated successfully");
        }
        return response([
            'message' => 'not authountcated'
        ], 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $comment = Q_A::find($id);
        if ($comment->user_id == $user_id || $user->hasRole('admin')) {
            $comment->delete();
            return $this->returnSuccessMessage("deletd successfully");
        }
        return response([
            'message' => 'not authountcated'
        ], 401);
    }
}
