<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AdminPermission;
use App\Models\AdminRole;
use App\Models\AdminRolePermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminRole::create(['name' => 'admin']);
        AdminPermission::create(['name' => 'all']);
        AdminRolePermission::create(['role_id' => 1, 'permission_id' => 1]);
        Admin::create([
            'login' => 'admin',
            'password' => Hash::make('12345678'),
            'role_id' => 1,
        ]);
    }
}
