<?php

namespace App\Http\Resources\enrollment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'enrollment_date' => $this->pluck('created_at'),
            'progress' => $this->pluck('progress'),

        ];
    }
}
