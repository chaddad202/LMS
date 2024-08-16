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
            'rating' => $this->getrate(),
            'price' => $this->price,
            'level' => $this->level,
            'instructors' => $this->user->name,
            'courseDuration' => $this->getcourseDuration(),
            'type' => $this->type,
            'categoryId' => $this->category->id,
            'category' => [

                'id' => $this->category->id,

                'name' => $this->category->name,
            ]
        ];
    }
    public function getcourseDuration()
    {
        if ($this->course_duration == NULL) {
            return 0;
        }
        return $this->course_duration;
    }
    public function getrate()
    {
        if ($this->rating == NULL) {
            return 0;
        }
        return $this->average_rating;
    }
}
