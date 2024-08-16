<?php

namespace App\Http\Resources\course;

use App\Models\Enrollment;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            'photo'  => asset('storage/' . str_replace('public/', '', $this->photo)),
            'title' => $this->title,
            'rating' => $this->rating,
            'price' => $this->price,
            'level' => $this->level,
            'instructors' => $this->user->name,
            'Course_Duration' => $this->course_duration,
            'isFavourte' => $this->isFavourite()
        ];
    }
    public function isFavourite()
    {
        // Get the authenticated user
        $user = Auth::user();

        if ($user) {
            $enroll = Enrollment::where('user_id', $user->id)
                ->where('course_id', $this->id)
                ->first();
            if ($enroll) {
                $favourite = Favorite::where('user_id', $user->id)
                    ->where('course_id', $this->id)
                    ->first();
                if ($favourite) {
                    return 'yes';
                }
                return 'no';  // Either not enrolled or not marked as favorite
            }
        }
    }
}
