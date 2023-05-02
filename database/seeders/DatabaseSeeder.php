<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GroupEducationTypeSeeder::class,
            SubjectTypeSeeder::class,
            SubjectTimeSeeder::class,
            TeacherDepartmentSeeder::class,
            TeacherPositionSeeder::class,
            WeekdaySeeder::class,
            AdminSeeder::class,
        ]);
    }
}
