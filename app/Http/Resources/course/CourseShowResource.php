<?php

namespace App\Http\Resources\course;

use App\Models\Course;
use App\Models\Course_skills;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Skills;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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
            'id' => $this->id,
            'teacher' => [
                'idTeacher' => $this->user->id,
                'nameTeacher' => $this->user->name,
                'photoTeacher' => asset('storage/' . str_replace('public/', '', $this->user->customer->photo)),
            ],
            'title' => $this->title,
            'description' => $this->description,
            'photo'  => asset('storage/' . str_replace('public/', '', $this->photo)),
            'price' => $this->price,
            'course_duration' => $this->course_duration,
            'level' => $this->level,
            'courseDuration' => $this->getcourseDuration(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'skills' => $this->getskill(),
            'goal' => $this->getgain(),
            'category' => [

                'id' => $this->category->id,

                'name' => $this->category->name,
            ],
            'num_of_enrollment' => $this->getnumenro(),
            'course_related' => $this->getcourse_related(),
            'rating' => $this->getrate(),
            'review' => $this->getreview(),
            'sections' => $this->getsection(),
            'type' => $this->type,


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
    public function getgain()
    {
        $res = [];
        foreach ($this->Gain_prequists as $Gain_prequist) {
            if ($Gain_prequist->status== 'prequisites'){
               $res[]=[
                    'prequisites'=>[
                        'id' => $Gain_prequist->id,
                        'text' => $Gain_prequist->text

                ]
                ];
            }

            $res[] = [
                'gain' => [
                    'id' => $Gain_prequist->id,
                    'text' => $Gain_prequist->text
                ]
            ];
        }
        return $res;
    }
    public function getskill()
    {
        $res = [];
        foreach ($this->skills as $skill) {
            $s =  Skills::find($skill->id);
            $title = $s->title;
            $courseskill =   Course_skills::where('skills_id', $skill->id)->where('course_id', $this->id)->first();
            $point = $courseskill->point;
            $status = $courseskill->status;

            $res[] = [
                'id' => $courseskill->id,
                'skill' => $s,
                'point' => $point,
                'status' => $status
            ];
        }
        return $res;
    }
    public function getnumenro()
    {
        return $this->enrollments()->count();
    }
    public function getcourse_related()
    {
        $res = [];
        $courses = Course::where('category_id', $this->category_id)->withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')->take(12)->get();
        foreach ($courses as $course) {
            $res[] = [
                'photo'  => asset('storage/' . str_replace('public/', '', $course->photo)),
                'title' => $course->title

            ];
        }
        return $res;
    }
    public function getAverageRating()
    {
        return $this->average_rating;
    }

    public function getreview()
    {
        $res = [];
        foreach ($this->reviews as $review) {
            $user = User::find($review->user_id);
            $res[] = [
                'id' => $review->id,
                'user_name' => $user->name,
                'created_at' => $review->created_at,
                'comment' => $review->comment

            ];
        }
        return $res;
    }
    public function getsection()
    {
        $res = [];
        foreach ($this->sections as $section) {
            $res[] = [
                'id' => $section->id,
                'title'  => $section->title,
                'section_duration' => $section->section_duration,
                'lesson' => [
                    'id'
                    => $section->lessons->pluck('id'),
                    'title' => $section->lessons->pluck('title'),
                    'lesson_duration' => $section->lessons->pluck('lesson_duration')
                ]
            ];
        }
        return $res;
    }
}
