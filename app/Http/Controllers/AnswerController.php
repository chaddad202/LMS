<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerRequest;
use App\Http\Requests\AnswerUpdateRequest;
use App\Models\Answer;
use App\Models\Mark;
use App\Models\Q_C;
use App\Models\Q_Q;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class AnswerController extends Controller
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
    public function store(AnswerRequest $request)
    {
        $quiz = Quiz::find($request->quiz_id);
        $question = $quiz->questions->where('id', $request->question_id)->first();

        Answer::create([
            'user_id' => auth()->user()->id,
            'quiz_id' => $quiz->id,
            'question_id' =>   $question->id,
            'choice_id' => $request->choice_id,
        ]);
        return response([
            'Data' => 'Created successfully ',
        ], 200);
    }

    public function my_mark(Request $request)
    {
        $request->validate(['quiz_id' => 'required|Integer|exists:quizzes,id',]);
        $user = auth()->user()->id;
        $mark = 0;

        $quiz = Quiz::find($request->quiz_id);
        $questions = $quiz->questions;

        $q_q = Q_Q::where('quiz_id', $request->quiz_id)
            ->whereIn('question_id', $questions->pluck('id'))
            ->get()
            ->keyBy('question_id');

        $getanswer = Answer::where('user_id', $user)
            ->where('quiz_id', $request->quiz_id)
            ->whereIn('question_id', $questions->pluck('id'))
            ->get();

        $answers = $getanswer->pluck('choice_id', 'question_id');

        $q_c = Q_C::whereIn('question_id', $questions->pluck('id'))
            ->where('status', 'true')
            ->get()
            ->pluck('choice_id', 'question_id');

        foreach ($answers as $question_id => $choice_id) {
            if (isset($q_c[$question_id]) && $q_c[$question_id] == $choice_id) {
                $mark += $q_q[$question_id]->mark;
            }
        }

        Mark::create([
            'quiz_id' => $request->quiz_id,
            'user_id' => $user,
            'mark' => $mark
        ]);

        return response([
            'Data' => "your mark $mark",
        ], 200);



        Mark::create([
            'quiz_id' => $request->quiz_id,
            'user_id' => $user,
            'mark' =>  $mark
        ]);
        return response([
            'Data' => "your mark $mark",
        ], 200);
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
    public function update(AnswerUpdateRequest $request)
    {
        $answer = Answer::where('user_id', auth()->user()->id)
            ->where('quiz_id', $request->quiz_id)
            ->where('question_id', $request->question_id)->first();
        $answer->update([
            'choice_id' => $request->choice_id
        ]);
        return response([
            'Data' => 'Updated successfully ',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
