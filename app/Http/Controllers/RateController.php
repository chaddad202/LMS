<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateRequest;
use App\Http\Resources\FilteringResource;
use App\Models\Rate;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use App\Models\Course;

class RateController extends Controller
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
    public function store(RateRequest $request, $course_id)
    {
        $user_id = auth()->user()->id;
        Rate::create([
            'user_id' => $user_id,
            'course_id' => $course_id,
            'value' => $request->value
        ]);
        $course = course::findOrFail($course_id);
        $course->number_of_rating += 1;
        $rating =  Rate::where('course_id', $course_id)->get();
        $value = 0;
        foreach ($rating->value as $ratings) {
            $value += $ratings;
        }
        $course->rating = $value / $course->number_of_rating;
        return $this->returnSuccessMessage('created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rate = [];
        if ($id == 1) {
            $rate = course::where('rating' >= 4.5)->get();
        } else  if ($id == 2) {
            $rate = course::where('rating' >= 4.0)->get();
        } else  if ($id == 3) {
            $rate = course::where('rating' >= 3.5)->get();
        } else  if ($id == 2) {
            $rate = course::where('rating' >= 3.0)->get();
        }
        return FilteringResource::collection($rate);
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
    public function update(RateRequest $request, $rate_id)
    {
        $rate = Rate::find($rate_id);
        $rate->update($request->all());
        $course = course::findOrFail($rate->course_id);
        $course->number_of_rating += 1;
        $rating =  Rate::where('course_id', $rate->course_id)->get();
        $value = 0;
        foreach ($rating->value as $ratings) {
            $value += $ratings;
        }
        $course->rating = $value / $course->number_of_rating;
        return $this->returnSuccessMessage('updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($rate_id)
    {
        $rate = Rate::find($rate_id);
        $rate->delete();
        $course = course::findOrFail($rate->course_id);
        $course->number_of_rating -= 1;
        $rating =  Rate::where('course_id', $rate->course_id)->get();
        $value = 0;
        foreach ($rating->value as $ratings) {
            $value += $ratings;
        }
        $course->rating = $value / $course->number_of_rating;
        return $this->returnSuccessMessage('deleted successfully');
    }
}
