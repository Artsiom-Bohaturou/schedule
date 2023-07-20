<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleGroupResource extends JsonResource
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
            'weeks' => $this->week_numbers,
            'subgroup' => $this->subgroup,
            'time' => new SubjectTimeResource($this->subjectTime),
            'weekday' => new WeekdayResource($this->weekday),
            'teacher' => new TeacherResource($this->teacher),
        ];
    }
}
