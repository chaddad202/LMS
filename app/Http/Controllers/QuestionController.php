<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Choice;
use App\Models\Q_Q;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class QuestionController extends Controller
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
    public function store(QuestionRequest $request, $quiz_id)
    {
        foreach ($request->question as $questionData) {
            $question = Question::create([
                'question' => $questionData['question'],
                'mark' => $questionData['mark'],
                'quiz_id' => $quiz_id
            ]);

            foreach ($questionData['choices'] as $choiceData) {
                Choice::create([
                    'choice_text' => $choiceData['choice_text'],
                    'isAnswer' => $choiceData['isAnswer'],
                    'question_id' => $question->id
                ]);
            }
        }
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
    public function update(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|Integer|exists:quizzes,id',
            'question_id'    => 'required|Integer|exists:questions,id',
            'question' => 'string',
            'mark' => 'Integer'
        ]);
        $Q_Q = Q_Q::where('quiz_id', $request->quiz_id)->where('question_id', $request->question_id)->first();
        if ($request->has('question')) {
            $question = Question::where('question', $request->question)->first();
            if (!$question) {
                $question =   Question::create(['question' => $request->question]);
            }
            $Q_Q->update(['question_id' => $question->id]);
        }
        if ($request->has('mark')) {
            $Q_Q->update(['mark' => $request->mark]);
        }
        return response([
            'messsage' => 'updated successfully',
        ], 200);
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|Integer|exists:quizzes,id',
            'question_id'    => 'required|Integer|exists:questions,id',
        ]);
        $Q_Q = Q_Q::where('quiz_id', $request->quiz_id)->where('question_id', $request->question_id);
        $Q_Q->delete();
        return response([
            'messsage' => 'destroyed successfully',
        ], 200);
    }
}
