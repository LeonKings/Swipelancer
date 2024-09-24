<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FreelancerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('freelancers')->insert([
            'users_id' => 2,
            'freelancer_image_link' => '1719926321.jpg',
            'freelancer_name' => 'Person',
            'last_study' => 'High',
            'field_of_work' => 2,
            'cv_link' => '1713360998.jpg',
            'portfolio' => 'Mager gw',
            'min_salary' => 500000,
            'max_salary' => 99999999,
            'section_1' => 9,
            'section_2' => 12,
            'section_3' => 10,
            'describe_yourselves' => 'Rajin',
            'created_community' => 0
        ]);
    }
}
