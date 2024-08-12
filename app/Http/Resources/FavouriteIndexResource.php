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
            'id' => $this->id,
            'courseName' => $this->course->title,
            'courseTeacher' => $this->course->user->name,
            'coursePhoto' => asset('storage/' . str_replace('public/', '',  $this->course->photo)),
            'description' => $this->course->description,
            'level' => $this->course->level,
            'price' => $this->course->price,
        ];
    }
}
