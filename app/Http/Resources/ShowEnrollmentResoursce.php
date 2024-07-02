<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Course;
use App\Models\User;

class ShowEnrollmentResoursce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'course_name'  => $this->pluck('title'),
            'users' => $this->nameusers()
        ];
    }
    public function nameusers()
    {
        $res = [];
        $enrollment = $this->pluck('enrollment');
        foreach ($enrollment as $enrollments) {
            $user = User::find($enrollments->user_id);
            $res = [
                'name' => $user->name,
            ];
        }
        return $res;
    }
}
