<?php

namespace App\Http\Resources\lesson;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'description'=> $this->description,
            'media' =>$this->media,
            'lesson_duration'=>$this->lesson_duration,
            'comment'=> $this->getcomment(),



        ];

    }
    public function getcomment()
    {
        $comments= $this->comments;
        $response=[];
        foreach ($comments as $comment) {
            if ($comment['comment_id'] == null) {
                $response[] = [
                    'lesson_id' => $comment->lesson_id,
                    'comment_id' => $comment->comment_id,
                    'comment' => $comment->comment,
                    'reply' => $comment->comments->pluck('comment')
                ];
                return $response;
    }
        }}}
