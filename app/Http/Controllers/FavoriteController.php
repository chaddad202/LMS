<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Models\User;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id  =  auth()->user()->id;
        $user = User::find($user_id);
        $favourite = $user->favourites;
        return response([
            'data' =>  $favourite
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

        ]);
        $user_id  =  auth()->user()->id;

        Favorite::create([
            'user_id' => $user_id,
            'course_id' => $request->course_id
        ]);
        return response([
            'message' => 'added to favourite successfuly'
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $request->validate([
            'course_id'  => 'required|Integer|exists:courses,id',

        ]);
        $user_id  =  auth()->user()->id;
        $favourite = Favorite::where('course_id', $request->course_id)
            ->where('user_id', $user_id)
            ->first();
        $favourite->delete();
        return response([
            'message' => 'deleted successfuly'
        ], 200);
    }
}
