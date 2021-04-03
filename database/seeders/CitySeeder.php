<?php

namespace Database\Seeders;

use App\Models\Common\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::truncate();
        $path = public_path('sql/cities.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
