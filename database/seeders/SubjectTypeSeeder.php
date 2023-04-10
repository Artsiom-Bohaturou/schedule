<?php

namespace Database\Seeders;

use App\Models\SubjectType;
use Illuminate\Database\Seeder;

class SubjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubjectType::insert([
            [
                'abbreviated_name' => 'ЛК',
                'full_name' => 'Лекция',
            ],
            [
                'abbreviated_name' => 'ЛР',
                'full_name' => 'Лабораторная работа',
            ],
            [
                'abbreviated_name' => 'ПЗ',
                'full_name' => 'Практическое занятие',
            ],
            [
                'abbreviated_name' => 'экз',
                'full_name' => 'экзамен',
            ],
            [
                'abbreviated_name' => 'конс-ция',
                'full_name' => 'консультация',
            ],
        ]);
    }
}
