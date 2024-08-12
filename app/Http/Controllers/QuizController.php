<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Http\Requests\enrollment\QuizUpdateRequest;
use App\Models\Choice;
use App\Models\Q_C;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Traits\GeneralTrait;

class QuizController extends Controller
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
    public function store(QuizRequest $request, $section_id)
    {
        $section = Section::findOrFail($section_id);
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authQuiz = auth()->user()->id;
        if ($user_id == $authQuiz) {
            Quiz::create([
                'name' => $request->name,
                'section_id' => $section_id
            ]);
            return $this->returnSuccessMessage("created successfully");
        }
        return response(['message' => 'not authountcated'], 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
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
    public function update(QuizUpdateRequest $request, $quiz_id)
    {
        $quiz = Quiz::find($quiz_id);
        $section = $quiz->section;
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authQuiz = auth()->user()->id;
        if ($user_id == $authQuiz) {
            $quiz->update($request->all());
            return $this->returnSuccessMessage("updated successfully");
        }
        return response(['message' => 'not authountcated'], 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($quiz_id)
    {
        $quiz = Quiz::find($quiz_id);
        $section = $quiz->section;
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authQuiz = auth()->user()->id;
        if ($user_id == $authQuiz) {
            $quiz->delete();
            return $this->returnSuccessMessage("destroyed successfully");
        }
        return response(['message' => 'not authountcated'], 401);
    }
}
