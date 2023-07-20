<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $department = is_null($this->department) ? null : [
            'full' => $this->department->full_name,
            'abbreviated' => $this->department->abbreviated_name,
        ];

        $position = is_null($this->position) ? null : [
            'full' => $this->position->full_name,
            'abbreviated' => $this->position->abbreviated_name,
        ];

        return [
            'id' => $this->id,
            'fullName' => $this->full_name,
            'department' => $department,
            'position' => $position,
        ];
    }
}
