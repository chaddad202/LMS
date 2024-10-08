<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewIndexResource;
use App\Http\Resources\ReviewShowResource;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use App\Models\Rate;
use App\Models\User;

class ReviewController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        $review = Review::all();
        return ReviewIndexResource::collection($review);
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
    public function store(ReviewRequest $request, $course_id)
    {
        $user = auth()->user()->id;
        $rate = Rate::where('course_id', $course_id)->where('user_id', $user)->first();
        if (!$rate) {
            return $this->returnError(304, 'you should rate before');
        }
        Review::create([
            'user_id' => $user,
            'course_id' => $course_id,
            'comment' => $request->comment

        ]);
        return $this->returnSuccessMessage('created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $review = Review::find($id);
        return new ReviewShowResource($review);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewRequest $request, $review_id)
    {
        if ($request->all() === null || count($request->all()) === 0) {
            return $this->returnError(400, 'request input is empty!');
        }
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $review = Review::find($review_id);
        if ($user_id == $review->user_id || $user->hasRole('admin')) {
            $review->update($request->all());
            return $this->returnSuccessMessage('updated successfully');
        }
        return $this->returnError(304, 'you cant edit this review');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($review_id)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $review = Review::find($review_id);
        if ($user_id == $review->user_id || $user->hasRole('admin')) {
            $review->delet();
            return $this->returnSuccessMessage('deleted successfully');
        }
        return $this->returnError(304, 'you cant delet this review');
    }
}
