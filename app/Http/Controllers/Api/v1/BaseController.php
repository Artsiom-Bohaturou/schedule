<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

class BaseController extends Controller
{
    protected function getScheduleBuilder($request = null)
    {
        $builder = parent::getScheduleBuilder()->whereIn('weekday_id', $request->weekdays)
            ->when($request->subgroup, function ($q) use ($request) {
                $q->where(function ($qu) use ($request) {
                    $qu->where('subgroup', $request->subgroup)->orWhere('subgroup', 0)->orWhereNull('subgroup');
                });
            })
            ->when($request->type, function ($q) use ($request) {
                $q->whereRelation('subjectType', 'abbreviated_name', '=', $request->type);
            })
            ->when($request->weeks, function ($q) use ($request) {
                $q->whereIn('week_number', $request->weeks);
            });

        return $this->dateFilter($builder);
    }

    protected function dateFilter($builder)
    {
        return $builder
            ->where('date_end', '>', now()->subMonth())
            ->where('date_start', '<', now()->addMonth());
    }

}
