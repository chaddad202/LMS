<?php

namespace App\Http\Resources\enrollment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentIndexSResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

        'courses'  =>  ['name'=>$this->pluck('course')->name]
        ];
    }
}
