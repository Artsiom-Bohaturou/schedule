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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleController extends BaseController
{
    public function index()
    {
        $schedule = Schedule::select(DB::raw('ANY_VALUE(id) as id,subject_id, subject_type_id,weekday_id,subject_time_id,group_id,teacher_id,building,auditory,subgroup,date, GROUP_CONCAT(week_number SEPARATOR ",") AS week_numbers'))
            ->groupBy('group_id', 'subject_id', 'subject_type_id', 'weekday_id', 'subject_time_id', 'teacher_id', 'building', 'auditory', 'subgroup', 'date', 'date_end', 'date_start')
            ->with('group', 'teacher', 'subject', 'subjectType', 'weekday')
            ->get();

        $time = SubjectTime::all();

        return view('admin.schedule.index', compact('schedule', 'time'));
    }

    public function store(ScheduleStoreRequest $request)
    {
        $data = $request->validated();

        if (!array_key_exists('weekdays', $data)) {
            Schedule::insert($data);

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
                unset($subject['week_numbers']);
                unset($subject['weekdays']);
                unset($subject['long']);
                $schedule[] = $subject;

                if (!is_null($data['long'])) {
                    $subject['subject_time_id']++;
                    $schedule[] = $subject;
                }
            }
        }

        Schedule::insert($schedule);

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
        $subject = Schedule::findOrFail($id);
        $subjects = Schedule::whereGroupId($subject->group_id)
            ->whereTeacherId($subject->teacher_id)
            ->whereSubjectId($subject->subject_id)
            ->whereSubjectTypeId($subject->subject_type_id)
            ->whereWeekdayId($subject->weekday_id)
            ->whereSubjectTimeId($subject->subject_time_id)
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
        $subject = Schedule::find($id);
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

            return redirect()->route('schedule.index')->with('success', 'success');
        } catch (\Exception $e) {
            if (Storage::exists($file->hashName())) {
                Storage::delete($file->hashName());
            }

            return redirect()->route('schedule.index')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
