<?php

namespace App\Http\Resources\category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Course;

class CategoryIndexResource extends JsonResource
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
            'name' =>  $this->name,
            'photo'  => asset('storage/' . str_replace('public/', '', $this->photo)),
            'availableCourses' => $this->getavailble()


        ];
    }
    public function getavailble()
    {
        $r = 0;
        $courses = Course::where('category_id', $this->id)->where('type', 'publish')->get();
        foreach ($courses as $course) {
            $r++;
        }
        return $r;
    }
}
