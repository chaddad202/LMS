<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Http\Requests\NoteUpdateRequest;
use App\Http\Resources\NoteResourse;
use Illuminate\Http\Request;
use App\Models\Note;
use App\Traits\GeneralTrait;

class NoteController extends Controller
{
    use GeneralTrait;
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
    public function store(NoteRequest $request, $lesson_id)
    {
        $user = auth()->user()->id;
        Note::create([
            'user_id' => $user,
            'lesson_id' => $lesson_id,
            'time' => $request->time,
            'note' => $request->note
        ]);
        return $this->returnSuccessMessage(" created succesfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $note = Note::find($id);
        return new NoteResourse($note);

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
    public function update(NoteUpdateRequest $request, $id)
    {
        if ($request->all() === null || count($request->all()) === 0) {
            return response(['message' => 'request input is empty!'], 403);
        }
        $note = Note::find($id);
        if ($note->user_id != auth()->user()->id) {
            return response(['message' => 'not authountcated'], 401);
        }
        $note->update($request->all());
        return $this->returnSuccessMessage(" updated succesfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $note = Note::find($id);
        if ($note->user_id != auth()->user()->id) {
            return response(['message' => 'not authountcated'], 401);
        }
        $note->delete();
        return $this->returnSuccessMessage(" deleted succesfully");
    }
}
