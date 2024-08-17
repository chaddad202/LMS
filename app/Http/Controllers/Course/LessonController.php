<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\lesson\LessonRequest;
use App\Http\Requests\lesson\LessonUpdateRequest;
use App\Http\Resources\lesson\LessonIndexResource;
use App\Http\Resources\lesson\LessonShowResource;
use App\Models\Comment;
use App\Models\Enrollment;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Type_of_lesson;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Mockery\Matcher\Not;
use App\Traits\GeneralTrait;

use function PHPUnit\Framework\isEmpty;

class LessonController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index($section_id)
    {

        $section = Section::find($section_id);
        return new LessonIndexResource($section);
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
    public function store(LessonRequest $request, $section_id)
    {
        $section = Section::findOrFail($section_id);
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authLesson = auth()->user()->id;
        $userauth = User::find($authLesson);
        if ($user_id == $authLesson || $userauth->hasRole('admin')) {
            $file = '';
            if ($request->hasFile('file')) {
                $file  = $request->file('file')->store('public/file_course');
            }
            Lesson::create([
                'file' => $file,
                'section_id' => $section_id,
                'title' => $request->title,
                'description' => $request->description,
            ]);
            return $this->returnSuccessMessage('Created successfully');
        }
        return $this->returnError(401, 'Unauthenticated');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lesson = Lesson::findOrFail($id);
        $section = Section::find($lesson->section_id);
        $course = $section->course;
        $user = $course->user;
        $user_id = auth()->user()->id;
        $user_login = User::find($user_id);
        $enrollment = Enrollment::where('user_id', $user_id)->where('course_id', $course->id)->first();
        if (($user_login->hasRole('student') && $enrollment) || ($user_login->hasRole('teacher') && $user_id == $user->id) || ($user_login->hasRole('admin'))) {
            return new LessonShowResource($lesson);
        }
        return $this->returnError(304, 'you cant watch lesson without enrollment');
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
    public function update(LessonUpdateRequest $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        $section = $lesson->section;
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authLesson = auth()->user()->id;
        $userauth = User::find($authLesson);
        if ($user_id == $authLesson || $userauth->hasRole('admin')) {
            if ($request->all() === null || count($request->all()) === 0) {
                return $this->returnError(403, 'request input is empty!');
            }
            if ($request->has('media')) {
                Storage::delete($lesson->media);
                $request->file('media')->store("public/file_course");
            }
            $lesson->update($request->all());

            return $this->returnSuccessMessage('updated successfully');
        }
        return $this->returnError(401, 'Unauthenticated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);
        $section = $lesson->section;
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authLesson = auth()->user()->id;
        $userauth = User::find($authLesson);
        if ($user_id == $authLesson || $userauth->hasRole('admin')) {
            $file = $lesson->file;
            Storage::delete($file);
            $lesson->delete();
            return $this->returnSuccessMessage('destoryed successfully');
        }
        return $this->returnError(401, 'Unauthenticated');
    }
}
