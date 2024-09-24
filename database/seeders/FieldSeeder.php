<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fields')->insert([
            'fields_of_work' => 'Writing & Translation'
        ]);
        DB::table('fields')->insert([
            'fields_of_work' => 'Graphic Design & Multimedia'
        ]);
        DB::table('fields')->insert([
            'fields_of_work' => 'Digital Marketing'
        ]);
        DB::table('fields')->insert([
            'fields_of_work' => 'Programming & Tech'
        ]);
        DB::table('fields')->insert([
            'fields_of_work' => 'Business & Admin'
        ]);
        DB::table('fields')->insert([
            'fields_of_work' => 'Engineering & Architecture'
        ]);
        DB::table('fields')->insert([
            'fields_of_work' => 'Legal'
        ]);
        DB::table('fields')->insert([
            'fields_of_work' => 'Education & Training'
        ]);
        DB::table('fields')->insert([
            'fields_of_work' => 'Arts & Crafts'
        ]);
        DB::table('fields')->insert([
            'fields_of_work' => 'Gamers'
        ]);
    }
}
