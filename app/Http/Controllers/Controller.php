<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getScheduleBuilder()
    {
        return Schedule::select(DB::raw('ANY_VALUE(id) as id,subject_id, subject_type_id,weekday_id,subject_time_id,group_id,teacher_id,building,auditory,subgroup,date,date_start,date_end, GROUP_CONCAT(DISTINCT week_number ORDER BY week_number ASC SEPARATOR ", ") AS week_numbers'))
            ->groupBy('group_id', 'subject_id', 'subject_type_id', 'weekday_id', 'subject_time_id', 'teacher_id', 'building', 'auditory', 'subgroup', 'date', 'date_end', 'date_start')
            ->with('group', 'teacher', 'subject', 'subjectType', 'weekday');
    }
}
