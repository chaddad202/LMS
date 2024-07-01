<?php

namespace App\Http\Resources\course;

use App\Models\Course_skills;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Skills;

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
            'name_of_teacher' => $this->user->name,
            'photo_of_teacher' => $this->user->teacher_profile->photo,
            'title' => $this->title,
            'description' => $this->description,
            'photo' => $this->photo,
            'price' => $this->price,
            'course_duration' => $this->course_duration,
            'number_of_student' => $this->number_of_student,
            'rating' => $this->rating,
            'number_of_rating' => $this->number_of_rating,
            'level' => $this->level,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'skils' => $this->getskill(),
            'categories_name' => $this->categories->pluck('name')

        ];
    }
    public function getskill()
    {
        $res = [];
        foreach ($this->skills as $skill) {
            $s =  Skills::find($skill->id);
            $title = $s->title;
            $courseskill =   Course_skills::where('skills_id', $skill->id)->where('course_id', $this->id)->first();
            $point = $courseskill->point;
            $res = [
                'title' => $title,
                'point' => $point
            ];
        }
        return $res;
    }
}
