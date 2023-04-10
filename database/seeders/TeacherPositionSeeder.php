<?php

namespace Database\Seeders;

use App\Models\TeacherPosition;
use Illuminate\Database\Seeder;

class TeacherPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TeacherPosition::insert([
            [
                'abbreviated_name' => 'асс.',
                'full_name' => 'Ассистент',
            ],
            [
                'abbreviated_name' => 'доц.',
                'full_name' => 'Доцент',
            ],
            [
                'abbreviated_name' => 'зав. каф.',
                'full_name' => 'Заведующий кафедрой',
            ],
            [
                'abbreviated_name' => 'преп.',
                'full_name' => 'Преподаватель',
            ],
            [
                'abbreviated_name' => 'преп. I кат.',
                'full_name' => 'Преподаватель I категории',
            ],
            [
                'abbreviated_name' => 'преп. II кат.',
                'full_name' => 'Преподаватель II категории',
            ],
            [
                'abbreviated_name' => 'преп. высш. кат.',
                'full_name' => 'Преподаватель высшей категории',
            ],
            [
                'abbreviated_name' => 'проф.',
                'full_name' => 'Профессор',
            ],
            [
                'abbreviated_name' => 'ст. преп.',
                'full_name' => 'Старший преподаватель',
            ],
        ]);
    }
}
