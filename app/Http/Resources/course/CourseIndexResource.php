<?php

namespace App\Http\Resources\course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'photo' => $this->photo,
            'title' => $this->title,
            'rating' => $this->rating,
            'price' => $this->price,
            'level' => $this->level,
            'instructors' => $this->user->name,
            'Course Duration' => $this->course_duration

        ];
    }
}
