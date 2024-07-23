<?php

namespace App\Http\Resources\lesson;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;

class LessonShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'file' => $this->file,
            'lesson_duration' => $this->lesson_duration,
            'comment' => $this->getcomment(),



        ];
    }
    public function getcomment()
    {
        $com = [];
        $re = [];
        $res = [];
        foreach ($this->comments as $comment) {
            if ($comment->comment_id == NULL) {
                $user_comment = User::find($comment->user_id);
                $comment_reply = Comment::where('comment_id', $comment->id)->get();
                $com = [

                    'title' => $comment->comment,
                    'user' => $user_comment->name
                ];
                foreach ($comment_reply as $reply) {
                    $user_reply = User::find($reply->user_id);
                    $re[] = [

                        'title' => $reply->comment,
                        'user' => $user_reply->name

                    ];
                }
                $res[] = [
                    'comment' => $com,
                    'comment_reply' => $re
                ];
                $re = [];
            }
        }
        return $res;
    }
}
