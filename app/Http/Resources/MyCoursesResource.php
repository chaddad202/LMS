<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyCoursesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'photo'  => asset('storage/' . str_replace('public/', '', $this->photo)),
            'title' => $this->title,
            'rating' => $this->rating,
            'price' => $this->price,
            'level' => $this->level,
            'instructors' => $this->user->name,
            'Course_Duration' => $this->course_duration,
            'type'=>$this->type,
            'category'=>$this->category->name
        ];
    }
}
