<?php

namespace Database\Seeders;

use App\Models\TeacherDepartment;
use Illuminate\Database\Seeder;

class TeacherDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TeacherDepartment::insert([
            [
                'abbreviated_name' => 'ВК',
                'full_name' => 'Военная кафедра',
            ],
            [
                'abbreviated_name' => 'ГН',
                'full_name' => 'Гуманитарных наук',
            ],
            [
                'abbreviated_name' => 'ДОРЯИ',
                'full_name' => 'Довузовского образования и русского языка как иностранного',
            ],
            [
                'abbreviated_name' => 'ЗОЖ',
                'full_name' => 'Здорового образа жизни',
            ],
            [
                'abbreviated_name' => 'ИКТ',
                'full_name' => 'Инфокоммуникационных технологий',
            ],
            [
                'abbreviated_name' => 'МИФ',
                'full_name' => 'Математики и физики',
            ],
            [
                'abbreviated_name' => 'ОИТПС',
                'full_name' => 'Организации и технологии почтовой связи',
            ],
            [
                'abbreviated_name' => 'ПДО',
                'full_name' => 'Последипломного образования',
            ],
            [
                'abbreviated_name' => 'ПОСТ',
                'full_name' => 'Программного обеспечения сетей телекоммуникаций',
            ],
            [
                'abbreviated_name' => 'РИТ',
                'full_name' => 'Радио и информационных технологий',
            ],
            [
                'abbreviated_name' => 'ТС',
                'full_name' => 'Телекоммуникационных систем',
            ],
            [
                'abbreviated_name' => 'ЦЭ',
                'full_name' => 'Цифровой экономики',
            ],
        ]);
    }
}
