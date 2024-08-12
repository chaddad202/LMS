<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'course_name' => $this->course->title,
            'course_teacher' => $this->course->user->name,
            'course_photo' => asset('storage/' . str_replace('public/', '',  $this->course->photo)),
            'description' => $this->course->description,
            'level' => $this->course->level,
            'price' => $this->course->price,
        ];
    }
}
