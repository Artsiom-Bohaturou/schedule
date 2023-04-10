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
                'name' => 'ВО(заочное)',
            ],
            [
                'name' => 'ВО(дневное)',
            ],
            [
                'name' => 'Магистратура(заочное)',
            ],
            [
                'name' => 'Магистратура(дневное)',
            ],
            [
                'name' => 'ССО(заочное)',
            ],
            [
                'name' => 'ССО(дневное)',
            ],
        ]);
    }
}
