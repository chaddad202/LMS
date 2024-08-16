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
            'id'=>$this->id,
            'name_of_teacher' => $this->user->name,
            'photo_of_teacher' => asset('storage/' . str_replace('public/', '', $this->user->customer->photo)),
            'title' => $this->title,
            'description' => $this->description,
            'photo'  =>asset('storage/' . str_replace('public/', '', $this->photo)),
            'price' => $this->price,
            'course_duration' => $this->course_duration,
            'level' => $this->level,
            'courseDuration' => $this->getcourseDuration(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'skils' => $this->getskill(),
            'what you will learn' => $this->getgain(),
             'category' => [

                'id' => $this->category->id,

                'name' => $this->category->name,
             ],
            'num_of_enrollment' => $this->getnumenro(),
            'course_related' => $this->getcourse_related(),
            'rating' => $this->getrate(),
            'review' => $this->getreview(),
            'section_and_lesson' => $this->getsection()


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
            $res[] = [
                'status' => $Gain_prequist->status,
                'text' => $Gain_prequist->text
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
                'title' => $title,
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
        foreach ($this->reviews
            as $review) {
            $user = User::find($review->user_id);
            $res[] = [
                'user_name' => $user->name,
                'created_at' => $this->created_at,
                'comment' => $this->comment

            ];
        }
        return $res;
    }
    public function getsection()
    {
        $res = [];
        foreach ($this->sections as $section) {
            $res[] = [
                'title'  => $section->title,
                'section_duration' => $section->section_duration,
                'lesson' => [
                    'title' => $section->lessons->pluck('title'),
                    'lesson_duration' => $section->lessons->pluck('lesson_duration')
                ]
            ];

        }
        return $res;
    }
}
