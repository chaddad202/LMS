<?php

namespace App\Http\Resources\course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseShowResource extends JsonResource
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
            'name_of_teacher' => $this->name,
            // 'photo' => $this->getPhoto(),
            'price' => $this->price,
            'rating' => $this->rating,
            'teacher' => $this->user->name,
        ];
    }
    public function getPhoto()
    {
        $res = '';
        if ($this->teacher_profile) {
            $res = $this->teacher_profile->photo;
        }
        return $res;
    }
}
