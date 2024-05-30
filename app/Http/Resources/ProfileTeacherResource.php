<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileTeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo' => $this->teacher_profile->photo,
            'knowledge' => $this->teacher_profile->knowledge,
            'headline' => $this->teacher_profile->headline,
            // 'photo' => $this->photo,
            // 'knowledge' => $this->knowledge,
            // 'description' => $this->description,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            'courses' => $this->courses ? count($this->courses) : 0,
            //'products_count' => $this->products ?  count($this->products) : 0 ,
            // 'profile' => $this->getprofile(),
            'MyCourses' => $this->getCourses(),
           

        ];
    }

    public function getCourses()
    {
        $res = [];
        if ($this->courses) {
            foreach ($this->courses  as $course) {
                $res[] = [
                    'title' => $course->title,
                    'photo' => $course->photo
                ];
            }
        }
        return $res;
    }
    public function getprofile()
    {
        $res = [];
        if ($this->teacher_profile) {

            $res[] = [
                'photo' => $this->teacher_profile->photo,
                'knowledge' => $this->teacher_profile->knowledge,
                'description' => $this->teacher_profile->description,
            ];
        }
        return $res;
    }
}
