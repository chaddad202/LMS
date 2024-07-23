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
            'photo' => $this->photo,
            'title_course' => $this->title,
            'Rating' => $this->rating,
            'price' => $this->price,
            'level' => $this->level,
            'instructor' => $this->user->name,
            'course_duration' => $this->course_duration,
        ];
    }
}
