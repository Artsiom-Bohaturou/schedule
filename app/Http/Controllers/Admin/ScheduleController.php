<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ScheduleStoreRequest;
use App\Http\Requests\Admin\ScheduleUpdateRequest;
use App\Models\Group;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\SubjectTime;
use App\Models\SubjectType;
use App\Models\Teacher;
use App\Models\Weekday;

class ScheduleController extends BaseController
{

    public function index()
    {
        $schedule = Schedule::with('group', 'teacher', 'subject', 'subjectType', 'weekday')->get();
        $time = SubjectTime::all();

        return view('admin.schedule.index', compact('schedule', 'time'));
    }

    public function store(ScheduleStoreRequest $request)
    {
        $data = $request->validated();
        Schedule::create($data);

        return redirect()->route('schedule.index');
    }

    public function update(ScheduleUpdateRequest $request, $id)
    {
        $data = $request->validated();
        // Group::findOrFail($id)->update($data);

        return redirect()->route('group.index');
    }

    public function show($id)
    {
        dd('show');
    }

    public function destroy($id)
    {
        // Group::destroy($id);

        return redirect()->route('group.index');
    }

    public function create()
    {
        $groups = Group::select(['id', 'name'])->whereDate('date_end', '>', now())->get();
        $teachers = Teacher::select(['id', 'full_name'])->get();
        $subjects = Subject::select(['id', 'full_name'])->get();
        $types = SubjectType::select(['id', 'full_name', 'exam', 'long'])->get();
        $weekdays = Weekday::all();
        $times = SubjectTime::all();

        return view('admin.schedule.create', compact('groups', 'teachers', 'subjects', 'types', 'weekdays', 'times'));
    }

    public function edit()
    {

    }
}
