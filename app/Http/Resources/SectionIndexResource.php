<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionIndexResource extends JsonResource
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
            'sectionName' => $this->getsection(),
        ];
    }
    public function getsection()
    {
        $res = [];
        foreach ($this->sections as $section) {
            $res[] = [
                'name ' => $section->title,
                'section_duration' => $section->section_duration,
            ];
        }
        return $res;
    }
}
