<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
            'name' => 'SP091',
            'education_type_id' => 1,
            'date_start' => '2020-09-01',
            'date_end' => '2024-03-03',
        ]);
    }
}
