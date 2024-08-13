<?php

namespace App\Http\Resources\Skills;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkillsShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'title' => $this->title,
            'maximunBeginner' => $this->maximunBeginner,
            'maximunIntemediate' => $this->maximunIntemediate,
            'maximunAdvanced' => $this->maximunAdvanced,

        ];
    }
}
