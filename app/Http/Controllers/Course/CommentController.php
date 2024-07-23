<?php

namespace App\Http\Controllers\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use App\Models\User;

class CommentController extends Controller
{
    use GeneralTrait;
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
    public function store(CommentRequest $request, $id)
    {
        $data = ([
            'lesson_id' => $id,
            'comment' => $request->comment,
            'user_id' => auth()->user()->id,
        ]);

        Comment::create($data);
        return $this->returnSuccessMessage('Created Succussfully');
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
    public function reply(CommentRequest $request, $id)
    {
        $comment = Comment::find($id);
        $user = auth()->user()->id;

        Comment::create([
            'lesson_id' => $comment->lesson_id,
            'comment' => $request->comment,
            'comment_id' => $id,
            'user_id' => $user
        ]);
        return $this->returnSuccessMessage('replyed successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, $id)
    {

        $comment = Comment::find($id);
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if ($comment->user_id == $user_id || $user->hasRole('admin')) {
            $comment->update([
                'comment' => $request->comment
            ]);
            return $this->returnSuccessMessage("updated successfully");
        }
        return $this->returnError(304, "not authountcated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $comment = Comment::find($id);
        if ($comment->user_id == $user_id || $user->hasRole('admin')) {
            $comment->delete();
            return $this->returnSuccessMessage("deletd successfully");
        }
        return $this->returnError(304, "not authountcated");
    }
}
