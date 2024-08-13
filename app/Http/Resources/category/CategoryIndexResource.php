<?php

namespace App\Http\Resources\category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'availbleCourse' => $this->getavailble()


        ];
    }
    public function getavailble()
    {
        $r = 0;
        foreach ($this->courses as $course) {
            $r++;
        }
        return $r;
    }
}
