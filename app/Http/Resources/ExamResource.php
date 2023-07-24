<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'subject' => new SubjectNameResource($this->subject),
            'type' => new SubjectTypeResource($this->subjectType),
            'auditory' => $this->auditory,
            'building' => $this->building,
            'teacher' => new TeacherResource($this->teacher),
            'group' => new GroupResource($this->group),
            'date' => $this->date,
        ];
    }
}
