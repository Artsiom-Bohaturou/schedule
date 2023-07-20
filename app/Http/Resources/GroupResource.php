<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'name' => $this->name,
            'type' => [
                'names' => [
                    'abbreviated' => $this->educationType->abbreviated_name,
                    'full' => $this->educationType->full_name,
                ],
                'timeType' => $this->educationType->time_type,
            ],
        ];
    }
}
