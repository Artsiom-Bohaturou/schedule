<?php

namespace Database\Seeders;

use App\Models\GroupEducationType;
use Illuminate\Database\Seeder;

class GroupEducationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GroupEducationType::insert([
            [
                'full_name' => 'Высшее образование',
                'abbreviated_name' => 'ВО',
                'time_type' => 'Заочное',
            ],
            [
                'full_name' => 'Высшее образование',
                'abbreviated_name' => 'ВО',
                'time_type' => 'Дневное',
            ],
            [
                'full_name' => 'Магистратура',
                'abbreviated_name' => '',
                'time_type' => 'Заочное',
            ],
            [
                'full_name' => 'Магистратура',
                'abbreviated_name' => '',
                'time_type' => 'Дневное',
            ],
            [
                'full_name' => 'Среднее специальное образование',
                'abbreviated_name' => 'ССО',
                'time_type' => 'Заочное',
            ],
            [
                'full_name' => 'Среднее специальное образование',
                'abbreviated_name' => 'ССО',
                'time_type' => 'Дневное',
            ],
        ]);
    }
}
