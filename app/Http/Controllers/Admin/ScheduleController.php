<?php

namespace App\Http\Controllers\Admin;

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
        $schedule = Schedule::with('group', 'teacher', 'subject', 'subjectType', 'weekday')->get();
        $time = SubjectTime::all();

        return view('admin.schedule.index', compact('schedule', 'time'));
    }

    public function store(ScheduleStoreRequest $request)
    {
        $data = $request->validated();
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
        $types = SubjectType::select(['id', 'full_name', 'exam'])->get();
        $weekdays = Weekday::all();
        $times = SubjectTime::all();

        return view('admin.schedule.create', compact('groups', 'teachers', 'subjects', 'types', 'weekdays', 'times'));
    }

    public function edit()
    {

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
