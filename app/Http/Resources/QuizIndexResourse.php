<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizIndexResourse extends JsonResource
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
            'question' => $this->getquestion(),
        ];
    }
    public function getquestion()
    {
        $res = [];
        $questions = $this->questions->shuffle()->take($this->num_of_question);
        foreach ($questions as $question) {
            $res[] = [
                'idQuestion' => $question->id,
                'question' => $question->question,
                'idChoice' => $question->choices->pluck('id'),
                'choice' => $question->choices->pluck('choice_text'),
            ];
        }
        return $res;
    }
}
