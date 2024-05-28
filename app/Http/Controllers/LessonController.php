<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Http\Requests\LessonUpdateRequest;
use App\Models\Comment;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Type_of_lesson;
use App\Models\Section;
use Illuminate\Support\Facades\Storage;
use Mockery\Matcher\Not;

use function PHPUnit\Framework\isEmpty;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate(['section_id' => 'required|Integer|exists:sections,id']);
        $section = Section::find($request->section_id);
        return response([
            'section' => $section->title,
            'lesson' => $section->lessons,

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
            return response([
                'lesson' => $lesson,
                '$type' => $type->type,
            ], 200);
        }
        return response([
            'YOU ARE NOT THE SAME TEACHER'
        ], 403);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $response = [];
        $request->validate(['lesson_id' => 'required|Integer|exists:lessons,id']);
        $lesson = Lesson::find($request->lesson_id);
        $comments = Comment::all()->where('lesson_id', $request->lesson_id);
        foreach ($comments as $comment) {
            if ($comment['comment_id'] == null) {
                $response[] = [
                    'lesson_id' => $comment->lesson_id,
                    'comment_id' => $comment->comment_id,
                    'comment' => $comment->comment,
                    'reply' => $comment->comments->pluck('comment')
                ];
            }
        }

        //$reply = $comment->comments;

        return response([
            'lesson' => $lesson,
            'comment ' => $response


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
    public function update(LessonUpdateRequest $request)
    {
        $section = Section::find($request->section_id);
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authLesson = auth()->user()->id;
        if ($user_id == $authLesson) {
            $lesson = Lesson::find($request->lesson_id);
            $media = $lesson->media;


            if ($request->has('title') || $request->has('description')) {
                $data = $request;
                $lesson->update($data->all());
            }

            if ($request->has('media')) {
                Storage::delete($lesson->media);
                $lesson->update(['media' => $media]);
                $type = Type::find($request->type_id);
                $media  = $request->file('media')->store("public/$type->type");
                $lesson->update([$media]);
            }

            return response([
                'message' => 'updated successfuly'
            ], 200);
        }
        return response([
            'YOU ARE NOT THE SAME TEACHER'
        ], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate(['lesson_id' => 'required|Integer|exists:lessons,id']);
        $section = Section::find($request->section_id);
        $course = $section->course;
        $user = $course->user;
        $user_id = $user->id;
        $authLesson = auth()->user()->id;
        if ($user_id == $authLesson) {
            $lesson = Lesson::find($request->lesson_id);
            $media = $lesson->media;
            Storage::delete($media);
            $lesson->delete();
            return response([
                'message' => 'deleted successfuly'
            ], 200);
        }
        return response([
            'YOU ARE NOT THE SAME TEACHER'
        ], 403);
    }
}
