<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerRequest;
use App\Http\Requests\AnswerUpdateRequest;
use App\Models\Answer;
use App\Models\Choice;
use App\Models\Mark;
use App\Models\Q_C;
use App\Models\Q_Q;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
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
    public function store(AnswerRequest $request, $quiz_id)
    {
        $user = auth()->user()->id;

        // Check the submission count
        $submissionCount = Answer::where('user_id', $user)
            ->where('quiz_id', $quiz_id)
            ->distinct('created_at')
            ->count('created_at');

        // If the user has already submitted answers 3 times, return an error message
        if ($submissionCount >= 3) {
            return $this->returnErrorMessage('You have already submitted answers for this quiz three times.');
        }

        // Iterate through the questions
        foreach ($request->question as $questionData) {
            $score = 0;
            $question = Question::find($questionData['id']);

            // Iterate through the choices
            foreach ($questionData['choices'] as $choiceData) {
                $choice = Choice::find($choiceData['id']);

                // Check if the choice is the correct answer
                if ($choice->isAnswer == true) {
                    $score = $question->mark;
                }

                // Create the answer record
                Answer::create([
                    'user_id' => $user,  // Removed the extra space here
                    'quiz_id' => $quiz_id,
                    'question_id' => $question->id,
                    'choice_id' => $choice->id,
                    'score' => $score,
                ]);
            }
        }

        return $this->returnSuccessMessage('Created successfully');
    }


    public function my_mark($quiz_id)
    {
        $user = auth()->user()->id;

        // Get the latest submission
        $latestSubmission = Answer::where('user_id', $user)
            ->where('quiz_id', $quiz_id)
            ->orderBy('created_at', 'desc')
            ->first();

        // If no submission is found, return an error message
        if (!$latestSubmission) {
            return response()->json([
                'status' => 'error',
                'message' => 'No submission found.'
            ], 404);
        }

        // Get the answers from the latest submission
        $answers = Answer::where('user_id', $user)
            ->where('quiz_id', $quiz_id)
            ->where('created_at', $latestSubmission->created_at)
            ->get();
        $quiz = Quiz::findOrFail($quiz_id);
        $mark_final =   $quiz->questions->pluck('mark')->sum();
        // Calculate the user's score
        $mark = 0;
        foreach ($answers as $answer) {
            $mark += $answer->score;
        }

        // Return success message with the result
        if ($mark >= $mark_final) {
            return response()->json([
                'status' => 'success',
                'message' => "You passed the exam with a mark of $mark."
            ], 200);
        }

        // If the mark is below the passing score
        return response()->json([
            'status' => 'success',
            'message' => "Unfortunately, you failed with a mark of $mark."
        ], 200);
    }


    /**
     * Display the specified resource.
     */
    public function returnErrorMessage($message)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], 400); // You can adjust the status code if needed
    }

    // Helper method for success messages
    public function returnSuccessMessage($message)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message
        ], 200); // Default status code 200 (OK)
    }

    // Other methods like store() and my_mark() go here

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
    public function update() {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
