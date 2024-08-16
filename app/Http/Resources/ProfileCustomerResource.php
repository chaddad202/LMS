<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class ProfileCustomerResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->created_at,
            'photo'  => asset('storage/' . str_replace('public/', '', $this->customer->photo)),
            'profession' => $this->customer->profession,
            'description' => $this->customer->description,
            'wallet' => $this->wallet
        ];
    }
}
