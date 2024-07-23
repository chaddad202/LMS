<?php

namespace App\Http\Resources\lesson;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'lesson_of_section' => $this->return(),
        ];
    }
    function return()
    {
        $res = [];
        foreach ($this->lessons as $lesson) {
            $res[] = [
                'lesson_title' => $lesson->title,
                'lesson_duration' => $lesson->lesson_duration
            ];
        }
        return $res;
    }
}
