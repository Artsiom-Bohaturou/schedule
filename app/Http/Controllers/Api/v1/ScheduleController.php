<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\ScheduleExamRequest;
use App\Http\Requests\Api\ScheduleGroupRequest;
use App\Http\Requests\Api\ScheduleTeacherRequest;
use App\Http\Resources\ExamResource;
use App\Http\Resources\ScheduleGroupCollection;
use App\Http\Resources\ScheduleTeacherCollection;
use App\Models\Group;
use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Http\Response;

class ScheduleController extends BaseController
{
    // Swagger

    public function group(ScheduleGroupRequest $request)
    {
        $group = Group::whereName($request->group)->firstOr(function () {
            abort(Response::HTTP_NOT_FOUND, "Group doesn't exists");
        });
        $schedule = $this->getScheduleBuilder($request)
            ->whereGroupId($group->id)
            ->get();

        return (new ScheduleGroupCollection($schedule))->setGroup($group);
    }

    public function teacher(ScheduleTeacherRequest $request)
    {
        $teacher = Teacher::where('full_name', 'like', "%$request->teacher%")->firstOr(function () {
            abort(Response::HTTP_NOT_FOUND, "Teacher doesn't exists");
        });
        $schedule = $this->getScheduleBuilder($request)
            ->whereTeacherId($teacher->id)
            ->get();

        return (new ScheduleTeacherCollection($schedule))->setTeacher($teacher);
    }

    public function exams(ScheduleExamRequest $request)
    {
        $builder = Schedule::whereRelation('subjectType', 'exam', '=', true)
            ->with('group', 'teacher', 'subject', 'subjectType');

        if ($request->teacher) {
            $schedule = $builder->whereRelation('teacher', 'full_name', 'like', "%$request->teacher%")->get();

            return ExamResource::collection($schedule);
        }

        $schedule = $builder->whereRelation('group', 'name', 'like', "%$request->group%")->get();

        return ExamResource::collection($schedule);
    }

}
