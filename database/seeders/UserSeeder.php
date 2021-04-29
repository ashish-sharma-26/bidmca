<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => Str::random(10),
            'last_name' => Str::random(10),
            'email' => 'lender2@mailinator.com',
            'password' => Hash::make('12345678'),
            'phone' => rand(1,1000000000),
            'user_type' => 2,
            'is_active' => 1,
        ]);
        DB::table('users')->insert([
            'first_name' => Str::random(10),
            'last_name' => Str::random(10),
            'email' => 'lender3@mailinator.com',
            'password' => Hash::make('12345678'),
            'phone' => rand(1,1000000000),
            'user_type' => 2,
            'is_active' => 1,
        ]);
        DB::table('users')->insert([
            'first_name' => Str::random(10),
            'last_name' => Str::random(10),
            'email' => 'lender4@mailinator.com',
            'password' => Hash::make('12345678'),
            'phone' => rand(1,1000000000),
            'user_type' => 2,
            'is_active' => 1,
        ]);
        DB::table('users')->insert([
            'first_name' => Str::random(10),
            'last_name' => Str::random(10),
            'email' => 'broker@mailinator.com',
            'password' => Hash::make('12345678'),
            'phone' => rand(1,1000000000),
            'user_type' => 1,
            'is_active' => 1,
        ]);
    }
}
