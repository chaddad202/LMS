<?php

namespace App\Http\Controllers;

use App\Http\Requests\Gain_prequistRequest;
use App\Http\Requests\Gain_prequistUpdateRequest;
use App\Models\Course;
use App\Models\Gain_prequist;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
class Gain_prequistController extends Controller
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
    public function store(Gain_prequistRequest $request, $course_id)
    {
        $course = Course::find($course_id);
        $user_auth = auth()->user()->id;
        if ($course->user_id != $user_auth) {
            return response(['message' => 'not authountcated'], 401);
        }
        Gain_prequist::create([
            'course_id' => $course_id,
            'text' => $request->text,
            'status' => $request->status
        ]);
        return $this->returnSuccessMessage('created successfully');
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
    public function update(Gain_prequistUpdateRequest $request,  $id)
    {
        $gain_prequist = Gain_prequist::find($id);
        $user_auth = auth()->user()->id;
        if ($gain_prequist->user_id != $user_auth) {
            return response(['message' => 'not authountcated'], 401);
        }
        if ($request->all() === null || count($request->all()) === 0) {
            return response(['message' => 'request is empty'], 403);
        }
        $gain_prequist->update($request->all());
        return $this->returnSuccessMessage('updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gain_prequist = Gain_prequist::find($id);
        $user_auth = auth()->user()->id;
        if ($gain_prequist->user_id != $user_auth) {
            return response(['message' => 'not authountcated'], 401);
        }
        $gain_prequist->delete();
        return $this->returnSuccessMessage('deleted successfully');
    }
}
