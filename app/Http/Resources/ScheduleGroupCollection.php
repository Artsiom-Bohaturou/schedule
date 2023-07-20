<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ScheduleGroupCollection extends ResourceCollection
{
    private $group;
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
                'group' => new GroupResource($this->group),
            ],
        ];
    }

    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }
}
