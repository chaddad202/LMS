<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user2 = auth()->user()->id;
        $user = User::find($user2);
        $enrollment = Enrollment::where('user_id', $user2)->get();
        return response([

            'course' => $enrollment,
        ], 200);
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
    public function store(Request $request)
    {
        $request->validate([
            'course_id'  => 'required|Integer|exists:courses,id',
            'user_id' => 'required|Integer|exists:users,id',

        ]);
        $data = $request->all();
        $enrollment = Enrollment::create($data);
        return response([
            'Data' => $enrollment,
        ], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $request->validate(['course_id'  => 'required|Integer|exists:courses,id']);
        $enrollment = Enrollment::where('course_id', $request->course_id)->get();
        $user_id = $enrollment->pluck("user_id");
        $user = User::find($user_id);

        return response([
            'user' => $user

        ], 200);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
