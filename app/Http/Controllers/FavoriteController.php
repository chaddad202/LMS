<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavouriteRequest;
use App\Http\Resources\FavouriteIndexResource;
use App\Models\Enrollment;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\GeneralTrait;

class FavoriteController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user()->id;
        $favourite = Favorite::where('user_id', $user)->get();
        if (!$favourite) {
            return response(['message' => 'not found'], 404);
        }
        return FavouriteIndexResource::collection($favourite);
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
    public function store( FavouriteRequest $request)
    {

        $course_id = $request->course_id;
        $user_id  =  auth()->user()->id;
        $enroll = Enrollment::where('user_id', $user_id)->where('course_id', $course_id)->first();
        if (!$enroll) {
            return response(['message' => 'not authountcated'], 401);
        }
        $favourite = Favorite::where('user_id', $user_id)->where('course_id', $course_id)->first();
        if ($favourite) {
            return response(['message' => 'you already add'], 401);
        }
        Favorite::create([
            'user_id' => $user_id,
            'course_id' => $course_id
        ]);
        return $this->returnSuccessMessage("created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user()->id;
        $favourite = Favorite::findOrFail($id);
        return new FavouriteIndexResource($favourite);
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
    public function destroy($id)
    {
        $user_auth = auth()->user()->id;
        $favourite = Favorite::find($id);
        if ($user_auth != $favourite->user_id) {
            return response(['message' => 'not authountcated'], 401);
        }
        $favourite->delete();
        return $this->returnSuccessMessage('deleted susseccfully');
    }
}
