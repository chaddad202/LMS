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
            'category' => [
                'name' =>  $this->name,
                'photo'  => $this->photo,
                'Availble course' => $this->getavailble()
            ],

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
