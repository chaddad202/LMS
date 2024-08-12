<?php

namespace App\Http\Resources\order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
class OrderShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_name' => $this->getuser(),
            'amount' => $this->amount,
        ];
    }
    public function getuser()
    {
        $user = User::where('id', $this->user_id)->first();
        return $user->name;
    }
}
