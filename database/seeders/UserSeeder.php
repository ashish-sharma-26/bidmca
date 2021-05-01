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
        // BORROWER ACCOUNTS
        DB::table('users')->insert([
            'first_name' => 'Test',
            'last_name' => 'Merchant1',
            'email' => 'testmerch1@bidmca.com',
            'password' => Hash::make('pw123'),
            'phone' => rand(1,1000000000),
            'user_type' => 3,
            'is_active' => 1,
        ]);
        DB::table('users')->insert([
            'first_name' => 'Test',
            'last_name' => 'Merchant2',
            'email' => 'testmerch2@bidmca.com',
            'password' => Hash::make('pw123'),
            'phone' => rand(1,1000000000),
            'user_type' => 3,
            'is_active' => 1,
        ]);
        DB::table('users')->insert([
            'first_name' => 'Test',
            'last_name' => 'Merchant3',
            'email' => 'testmerch3@bidmca.com',
            'password' => Hash::make('pw123'),
            'phone' => rand(1,1000000000),
            'user_type' => 3,
            'is_active' => 1,
        ]);

        // BROKER ACCOUNTS
        DB::table('users')->insert([
            'first_name' => 'Test',
            'last_name' => 'ISO1',
            'email' => 'testiso1@bidmca.com',
            'password' => Hash::make('pw123'),
            'phone' => rand(1,1000000000),
            'user_type' => 1,
            'is_active' => 1,
        ]);
        DB::table('users')->insert([
            'first_name' => 'Test',
            'last_name' => 'ISO2',
            'email' => 'testiso2@bidmca.com',
            'password' => Hash::make('pw123'),
            'phone' => rand(1,1000000000),
            'user_type' => 1,
            'is_active' => 1,
        ]);
        DB::table('users')->insert([
            'first_name' => 'Test',
            'last_name' => 'ISO3',
            'email' => 'testiso3@bidmca.com',
            'password' => Hash::make('pw123'),
            'phone' => rand(1,1000000000),
            'user_type' => 1,
            'is_active' => 1,
        ]);

        // LENDER ACCOUNTS
        DB::table('users')->insert([
            'first_name' => 'Test',
            'last_name' => 'Synd1',
            'email' => 'testsynd1@bidmca.com',
            'password' => Hash::make('pw123'),
            'phone' => rand(1,1000000000),
            'user_type' => 2,
            'is_active' => 1,
        ]);
        DB::table('users')->insert([
            'first_name' => 'Test',
            'last_name' => 'Synd2',
            'email' => 'testsynd2@bidmca.com',
            'password' => Hash::make('pw123'),
            'phone' => rand(1,1000000000),
            'user_type' => 2,
            'is_active' => 1,
        ]);
        DB::table('users')->insert([
            'first_name' => 'Test',
            'last_name' => 'Synd3',
            'email' => 'testsynd3@bidmca.com',
            'password' => Hash::make('pw123'),
            'phone' => rand(1,1000000000),
            'user_type' => 2,
            'is_active' => 1,
        ]);
    }
}
