<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\section\SectionRequest;
use App\Http\Requests\section\SectionUpdateRequest;
use App\Http\Resources\SectionIndexResource;
use App\Http\Resources\SectionShowResource;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\User;
use App\Traits\GeneralTrait;

class SectionController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index($course_id)
    {
        $course = Course::find($course_id);
        return new SectionIndexResource($course);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request, $course_id)
    {

        $course = Course::findOrFail($course_id);
        $user = $course->user;
        $user_id = $user->id;
        $authSection = auth()->user()->id;
        $user_auth = User::find($authSection);

        if ($user_id == $authSection || $user_auth->hasRole('admin')) {

            Section::create([
                'title' => $request->title,
                'course_id' => $course_id,
            ]);
            return $this->returnSuccessMessage('created successfully');
        }
        return $this->returnError(401, 'Unauthenticated');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $section = Section::find($id);
        return new SectionShowResource($section);
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
    public function update(SectionUpdateRequest $request, $id)
    {
        $section = Section::findOrFail($id);
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authSection = auth()->user()->id;
        $user_auth = User::find($authSection);

        if ($user_id == $authSection || $user_auth->hasRole('admin')) {
            if ($request->all() === null || count($request->all()) === 0) {
                return $this->returnError(403, 'request input is empty!');
            }
            $section->update($request->all());

            return $this->returnSuccessMessage('updated successfully');
        }
        return $this->returnError(401, 'Unauthenticated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $section = Section::findOrFail($id);
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authSection = auth()->user()->id;
        $user_auth = User::find($authSection);
        if ($user_auth->hasRole('admin') ||  $user_id == $authSection) {
            $section->delete();
            return $this->returnSuccessMessage('deleted successfully');
        }
        return $this->returnError(401, 'Unauthenticated');
    }
}
