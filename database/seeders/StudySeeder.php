<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('studies')->insert([
            'last_study' => "High School"
        ]);
        DB::table('studies')->insert([
            'last_study' => "Bachelor's Degree"
        ]);
        DB::table('studies')->insert([
            'last_study' => "Master's Degree"
        ]);
        DB::table('studies')->insert([
            'last_study' => "Ph.D Degree"
        ]);
    }
}
