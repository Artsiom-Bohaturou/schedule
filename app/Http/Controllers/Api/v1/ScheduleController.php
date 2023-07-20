<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\ScheduleGroupRequest;
use App\Http\Requests\Api\ScheduleTeacherRequest;
use App\Http\Resources\ScheduleGroupCollection;
use App\Http\Resources\ScheduleTeacherCollection;
use App\Models\Group;
use App\Models\Teacher;

class ScheduleController extends BaseController
{
    // Добавить отправку экзаменов
    // Swagger

    public function group(ScheduleGroupRequest $request)
    {
        $group = Group::whereName($request->group)->first();
        $schedule = $this->getScheduleBuilder($request)
            ->whereGroupId($group->id)
            ->get();

        return (new ScheduleGroupCollection($schedule))->setGroup($group);
    }

    public function teacher(ScheduleTeacherRequest $request)
    {
        $teacher = Teacher::where('full_name', 'like', "%$request->teacher%")->first();
        $schedule = $this->getScheduleBuilder($request)
            ->whereTeacherId($teacher->id)
            ->get();

        return (new ScheduleTeacherCollection($schedule))->setTeacher($teacher);
    }

}