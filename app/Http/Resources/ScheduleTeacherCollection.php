<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ScheduleTeacherCollection extends ResourceCollection
{
    private $teacher;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'schedule' => $this->collection,
                'teacher' => new TeacherResource($this->teacher),
            ],
        ];
    }

    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;

        return $this;
    }
}
