<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Course;

class FilteringResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'courses' =>

            [
                'photo'  => asset('storage/' . str_replace('public/', '', $this->photo)),
                'title_course' => $this->title,
                'average_rating' => $this->average_rating,
                'price' => $this->price,
                'level' => $this->level,
                'instructor' => $this->user->name,
                'course_duration' => $this->course_duration,
            ]


        ];
    }
}
