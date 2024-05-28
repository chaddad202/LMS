<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'lesson_id' => 'required|Integer|exists:lessons,id',
            'comment' => 'required|string'
        ]);
        $user = auth()->user()->id;
        $data['user_id'] = $user;
        Comment::create($data);
        return response([
            'message' => 'created successfuly'
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
    public function reply(Request $request)
    {
        $data = $request->validate([
            'lesson_id' => 'required|Integer|exists:lessons,id',
            'comment' => 'required|string',
            'comment_id' => 'required|integer|exists:comments,id',
        ]);
        $user = auth()->user()->id;
        Comment::create([
            'lesson_id' => $request->lesson_id,
            'comment_id' => $request->comment_id,
            'comment' => $request->comment,
            'user_id' => $user
        ]);
        return response([
            'message' => 'created successfuly'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'lesson_id' => 'required|Integer|exists:lessons,id',
            'comment_id'
            => 'required|Integer|exists:comments,id',
            'comment' => 'required|string'
        ]);
        $user = auth()->user()->id;
        $comment = Comment::where('lesson_id', $request->lesson_id)->where('user_id', $user)->first();
        $comment->update([
            'comment' => $request->comment
        ]);
        return response([
            'message' => 'updated successfuly'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = $request->validate([
            'lesson_id' => 'required|Integer|exists:lessons,id',
        ]);
        $user = auth()->user()->id;
        $comment = Comment::where('lesson_id', $request->lesson_id)->where('user_id', $user)->first();
        $comment->delete();
        return response([
            'message' => 'deleted successfuly'
        ], 200);
    }
}
