<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChoiceRequest;
use App\Http\Requests\ChoiceUpdateRequest;
use App\Models\Choice;
use App\Models\Q_C;
use Illuminate\Http\Request;
use App\Models\Question;

class ChoiceController extends Controller
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
    public function store(ChoiceRequest $request)
    {
        $choice = Choice::where('choice_text', $request->choice_text)->first();
        if (!$choice) {
            $choice =   Choice::create(['choice_text' => $request->choice_text]);
        }

        $q_c = Q_C::create([
            'question_id' => $request->question_id,
            'choice_id' => $choice->id,
            'status' => $request->status
        ]);
        return response([
            'messsage' => 'created successfully',
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
    public function update(ChoiceUpdateRequest $request)
    {
        $q_c =  Q_C::where('question_id', $request->question_id)->where('choice_id', $request->choice_id)->first();
        if ($request->has('choice_text')) {
            $choice = Choice::where('choice_text', $request->choice_text);
            if (!$choice) {
                $choice =   Question::create(['choice_text' => $request->choice_text]);
            }
            $q_c->update(['choice_id' => $choice->id,]);
        }
        if ($request->has('status')) {
            $q_c->update(['status' => $request->status]);
        }
        return response([
            'messsage' => 'updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'question_id' => 'required|Integer|exists:questions,id',
            'choice_id'  => 'required|Integer|exists:choices,id',
        ]);
        $q_c =  Q_C::where('question_id', $request->question_id)->where('choice_id', $request->choice_id)->first();
        $q_c->delete();
        return response([
            'messsage' => 'daleted successfully',
        ], 200);
    }
}
