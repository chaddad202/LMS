<?php

namespace App\Http\Resources\category;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'course_number' => $this->getnumenro(),
            'courses' => $this->getcourse()
        ];
    }
    public function getcourse()
    {
        $res = [];
        foreach ($this->courses as $course) {
            $user = User::find($course->user_id);
            $res[] = [
                'photo' => asset('storage/' . str_replace('public/', '', $course->photo)),
                'title_course' => $course->title,
                'Rating' => $course->rating,
                'price' => $course->price,
                'level' => $course->level,
                'instructor' => $user->name,
                'course_duration' => $course->course_duration
            ];
        }
        return $res;
    }
    public function getnumenro()
    {
        return $this->courses()->count();
    }
}
