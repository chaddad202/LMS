<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewShowResource extends JsonResource
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
            'photo' => asset('storage/' . str_replace('public/', '', $this->user->photo)),
            'name' => $this->user->name,
            'date' => $this->created_at,
            'comment' => $this->comment
        ];
    }
}
