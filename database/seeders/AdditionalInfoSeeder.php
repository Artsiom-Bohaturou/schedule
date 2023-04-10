<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdditionalInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            GroupSeeder::class,
            ScheduleSeeder::class,
            SubjectSeeder::class,
            TeacherSeeder::class,
            UserSeeder::class,
        ]);
    }
}
