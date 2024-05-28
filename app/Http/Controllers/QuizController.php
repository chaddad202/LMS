<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Http\Requests\QuizUpdateRequest;
use App\Models\Choice;
use App\Models\Q_C;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\Section;

class QuizController extends Controller
{
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
    public function store(QuizRequest $request)
    {
        $section = Section::find($request->section_id);
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authQuiz = auth()->user()->id;
        if ($user_id == $authQuiz) {
            Quiz::create($request->all());
            return response([
                'messsage' => 'Created successfully',
            ], 200);
        }
        return response([
            'YOU ARE NOT THE SAME TEACHER'
        ], 403);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $request->validate([
            'quiz_id'  => 'required|Integer|exists:quizzes,id',
        ]);
        $quiz = Quiz::find($request->quiz_id);
        $question = $quiz->questions;
        $q_c = Q_C::where('question_id', $question->pluck('id'));
        $choises = Choice::find($q_c->pluck('choice_id'));
        return response([
            'quiz' => $quiz,
            'question' => $question,
            'choises' => $choises
        ], 403);
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
    public function update(QuizUpdateRequest $request)
    {
        $section = Section::find($request->section_id);
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authQuiz = auth()->user()->id;
        if ($user_id == $authQuiz) {
            $quiz = Quiz::find($request->quiz_id);
            $quiz->update($request->all());
            return response([
                'messsage' => 'updated successfully',
            ], 200);
        }
        return response([
            'YOU ARE NOT THE SAME TEACHER'
        ], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate(['quiz_id' => 'required|Integer|exists:quizzes,id']);
        $quiz = Quiz::find($request->quiz_id);
        $section = $quiz->section;
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authQuiz = auth()->user()->id;
        if ($user_id == $authQuiz) {
            $quiz->delete();
            return response([
                'messsage' => 'deleted successfully',
            ], 200);
        }
        return response([
            'YOU ARE NOT THE SAME TEACHER'
        ], 403);
    }
}
