<?php

namespace Database\Seeders;

use App\Models\SubjectTime;
use Illuminate\Database\Seeder;

class SubjectTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubjectTime::insert([
            [
                'time_start' => '08:00',
                'time_end' => '09:40',
            ],
            [
                'time_start' => '09:55',
                'time_end' => '11:35',
            ],
            [
                'time_start' => '12:15',
                'time_end' => '13:55',
            ],
            [
                'time_start' => '14:10',
                'time_end' => '15:50',
            ],
            [
                'time_start' => '16:20',
                'time_end' => '18:00',
            ],
            [
                'time_start' => '18:15',
                'time_end' => '19:55',
            ],
            [
                'time_start' => '20:10',
                'time_end' => '21:50',
            ],
        ]);
    }
}
