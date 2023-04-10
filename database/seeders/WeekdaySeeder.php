<?php

namespace Database\Seeders;

use App\Models\Weekday;
use Illuminate\Database\Seeder;

class WeekdaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Weekday::insert([
            [
                'name' => 'Понедельник',
            ],
            [
                'name' => 'Вторник',
            ],
            [
                'name' => 'Среда',
            ],
            [
                'name' => 'Четверг',
            ],
            [
                'name' => 'Пятница',
            ],
            [
                'name' => 'Суббота',
            ],
            [
                'name' => 'Воскресенье',
            ],
        ]);
    }
}
