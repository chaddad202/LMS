<?php

namespace App\Http\Resources\enrollment;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\Strings;

class EnrollmentShowIndex extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'number_of_student' => $this->getnum(),
            'user_name' => $this->getname()
        ];
    }
    public function getnum()
    {
        $num_of_student = 0;

        if ($this->pluck('user_id')) {
            foreach ($this->pluck('user_id') as $user) {
                $num_of_student += 1;
            }
        }

        return  $num_of_student;
    }
    public function getname()
    {
        $nameuser = [];


        foreach ($this->pluck('user_id') as $user1) {
            $userid = User::find($user1);
            $nameuser[] = $userid->name;
        }
        return  $nameuser;
    }
}
