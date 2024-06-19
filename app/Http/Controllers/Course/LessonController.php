<?php

namespace App\Http\Controllers\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\lesson\LessonRequest;
use App\Http\Requests\lesson\LessonUpdateRequest;
use App\Http\Resources\lesson\LessonIndexResource;
use App\Http\Resources\lesson\LessonShowResource;
use App\Models\Comment;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Type_of_lesson;
use App\Models\Section;
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
    public function store(LessonRequest $request)
    {
        $section = Section::find($request->section_id);
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authLesson = auth()->user()->id;
        if ($user_id == $authLesson) {
            $type = Type::find($request->type_id);
            $media  = $request->file('media')->store("public/$type->type");
            $lesson = Lesson::create([
                'section_id' => $request->section_id,
                'title' => $request->title,
                'description' => $request->description,
                'media' => $media,
            ]);

            Type_of_lesson::create([
                'lesson_id' => $lesson->id,
                'type_id' => $type->id,
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
        $lesson = Lesson::find($id);
         return new LessonShowResource($lesson);
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
        $lesson = Lesson::find($id);
        $section = $lesson->section;
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authLesson = auth()->user()->id;
        if ($user_id == $authLesson) {
            $media = $lesson->media;

            if ($request->has('title') || $request->has('description')) {
                $data = $request;
                $lesson->update($data->all());
            }

            if ($request->has('media')) {
                Storage::delete($lesson->media);
                $type = Type::find($request->type_id);
                $media  = $request->file('media')->store("public/$type->type");
                $lesson->update([$media]);
            }

            return $this->returnSuccessMessage('updated successfully');
        }
        return $this->returnError(401, 'Unauthenticated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lesson = Lesson::find($id);
        $section = $lesson->section;
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authLesson = auth()->user()->id;
        if ($user_id == $authLesson) {
            $media = $lesson->media;
            Storage::delete($media);
            $lesson->delete();
            return $this->returnSuccessMessage('destoryed successfully');
        }
        return $this->returnError(401, 'Unauthenticated');
    }
}
