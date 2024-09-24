<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('employers')->insert([
            'users_id' => 1,
            'employer_image_link' => '1719926321.jpg',
            'employer_type' => 'Person',
            'employer_name' => 'Lemuel Asaf'
        ]);
    }
}
