<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'photo' => $this->pluck('user')->pluck('photo'),
            'name' => $this->pluck('user')->pluck('name'),
            'date' => $this->pluck('created_at'),
            'comment' => $this->pluck('comment')
        ];
    }
}
