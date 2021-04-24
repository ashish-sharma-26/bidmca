<?php

namespace Database\Seeders;

use App\Models\Admin\Admin;
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
        Admin::truncate();
        Admin::create([
            'full_name' => 'Super Admin',
            'email' => 'superadmin@bidmca.com',
            'password' => Hash::make('Hi@bidmca'),
            'type' => 1,
            'is_active' => 1
        ]);
    }
}
