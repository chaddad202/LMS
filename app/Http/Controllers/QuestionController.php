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
            return $this->returnSuccessMessage(" created succesfully");

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, $question_id)
    {
        $question = Question::findOrFail($question_id);
        if ($request->all() === null || count($request->all()) === 0) {
            return response(['message' => 'request input is empty!'], 403);
        }
        if ($question->user_id != auth()->user()->id) {
            return response(['message' => 'not authountcated'], 401);
        }
        $question->update($request->all());
        return $this->returnSuccessMessage(" updated succesfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($question_id)
    {
        $question = Question::findOrFail($question_id);
        if ($question->user_id != auth()->user()->id) {
            return response(['message' => 'not authountcated'], 401);
        }
        $question->delete();
        return $this->returnSuccessMessage(" deleted succesfully");
    }
}
