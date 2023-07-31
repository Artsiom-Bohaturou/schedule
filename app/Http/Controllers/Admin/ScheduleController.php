<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ScheduleDestroyRequest;
use App\Http\Requests\Admin\ScheduleImportRequest;
use App\Http\Requests\Admin\ScheduleStoreRequest;
use App\Http\Requests\Admin\ScheduleUpdateRequest;
use App\Imports\ScheduleImport;
use App\Models\Group;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\SubjectTime;
use App\Models\SubjectType;
use App\Models\Teacher;
use App\Models\Weekday;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleController extends BaseController
{
    public function index()
    {
        $schedule = $this->getScheduleBuilder()
            ->get();

        $time = SubjectTime::all();

        return view('admin.schedule.index', compact('schedule', 'time'));
    }

    public function store(ScheduleStoreRequest $request)
    {
        $data = $request->validated();

        if (!array_key_exists('weekdays', $data)) {
            Schedule::create($data);

            return redirect()
                ->route('schedule.index')
                ->with('success', true);
        }

        $schedule = [];

        foreach ($data['weekdays'] as $day) {
            foreach ($data['week_numbers'] as $week) {
                $subject = $data;
                $subject['weekday_id'] = $day;
                $subject['week_number'] = $week;
                $subject['created_at'] = now();
                $subject['updated_at'] = now();
                unset($subject['week_numbers'], $subject['weekdays'], $subject['long']);
                $schedule[] = $subject;

                if (!is_null($data['long'])) {
                    $subject['subject_time_id']++;
                    $schedule[] = $subject;
                }
            }
        }

        Schedule::insert($schedule);

        return redirect()->route('schedule.index')->with('success', true);
    }

    public function update(ScheduleUpdateRequest $request, $id)
    {
        $data = $request->validated();

        if (array_key_exists('date', $data)) {
            Schedule::findOrFail($id)->update($data);

            return redirect()->route('schedule.index')->with('success', true);
        }

        $schedule = Schedule::whereIn('id', $data['ids'])->get();
        $exists = [];

        foreach ($schedule as $v) {
            if (!in_array($v->week_number, $data['week_numbers'])) {
                $v->delete();
                continue;
            }

            $exists[] = $v->week_number;
        }

        foreach ($data['week_numbers'] as $v) {
            if (!in_array($v, $exists)) {
                $new = new Schedule($data);
                $new->week_number = $v;
                $new->save();
                $schedule->add($new);
            }
        }

        unset($data['week_numbers'], $data['ids']);
        $schedule->toQuery()->update($data);

        return redirect()->route('schedule.index')->with('success', true);
    }

    public function show($id)
    {
        $subject = Schedule::findOrFail($id);
        $subjects = Schedule::whereGroupId($subject->group_id)
            ->whereTeacherId($subject->teacher_id)
            ->whereSubjectId($subject->subject_id)
            ->whereSubjectTypeId($subject->subject_type_id)
            ->whereWeekdayId($subject->weekday_id)
            ->whereSubjectTimeId($subject->subject_time_id)
            ->whereSubgroup($subject->subgroup)
            ->with('group', 'teacher', 'subject', 'subjectType', 'weekday')
            ->get();

        return view('admin.schedule.show', compact('subjects'));
    }

    public function destroy(ScheduleDestroyRequest $request)
    {
        $ids = $request->validated()['id'];
        Schedule::whereIn('id', $ids)->delete();

        return redirect()->route('schedule.index');
    }

    public function create()
    {
        $groups = Group::select(['id', 'name'])->whereDate('date_end', '>', now())->get();
        $teachers = Teacher::select(['id', 'full_name'])->get();
        $subjects = Subject::select(['id', 'full_name'])->get();
        $types = SubjectType::select(['id', 'full_name', 'exam'])->get();
        $weekdays = Weekday::all();
        $times = SubjectTime::all();

        return view('admin.schedule.create', compact('groups', 'teachers', 'subjects', 'types', 'weekdays', 'times'));
    }

    public function edit($id)
    {
        $subject = Schedule::findOrFail($id);
        $groups = Group::select(['id', 'name'])->whereDate('date_end', '>', now())->get();
        $teachers = Teacher::select(['id', 'full_name'])->get();
        $subjects = Subject::select(['id', 'full_name'])->get();
        $types = SubjectType::select(['id', 'full_name', 'exam'])->get();
        $weekdays = Weekday::all();
        $times = SubjectTime::all();
        $default = Schedule::whereGroupId($subject->group_id)
            ->whereTeacherId($subject->teacher_id)
            ->whereSubjectId($subject->subject_id)
            ->whereSubjectTypeId($subject->subject_type_id)
            ->whereWeekdayId($subject->weekday_id)
            ->whereSubjectTimeId($subject->subject_time_id)
            ->whereSubgroup($subject->subgroup)
            ->get();

        return view('admin.schedule.edit', compact('groups', 'teachers', 'subjects', 'types', 'weekdays', 'times', 'default'));
    }

    public function import(ScheduleImportRequest $request)
    {
        $file = $request->file('file');
        try {
            Storage::put('/', $file);
            Excel::import(new ScheduleImport, Storage::path($file->hashName()));
            Storage::delete($file->hashName());

            return redirect()->route('schedule.index')->with('success', true);
        } catch (\Exception $e) {
            if (Storage::exists($file->hashName())) {
                Storage::delete($file->hashName());
            }

            return redirect()->route('schedule.index')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function deleteEnded()
    {
        Schedule::where('date_end', '<', now())->delete();

        return redirect()->route('schedule.index')->with('success', true);
    }
}
