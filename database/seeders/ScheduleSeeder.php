<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schedule::create([
            'group_id' => 1,
            'teacher_id' => 1,
            'subject_id' => 1,
            'subject_type_id' => 1,
            'week_number' => 1,
            'weekday_id' => 1,
            'building' => 1,
            'auditory' => 1,
            'subgroup' => 1,
            'subject_time_id' => 1,
            'date_start' => '2020-05-05',
            'date_end' => '2020-06-06',
        ]);
    }
}
