<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 1,
            'project_section' => 1,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 1,
            'project_section' => 2,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 1,
            'project_section' => 3,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 2,
            'project_section' => 9,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 2,
            'project_section' => 10,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 2,
            'project_section' => 11,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 3,
            'project_section' => 16,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 3,
            'project_section' => 17,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 3,
            'project_section' => 18,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 4,
            'project_section' => 23,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 4,
            'project_section' => 24,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 4,
            'project_section' => 25,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 5,
            'project_section' => 30,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 5,
            'project_section' => 31,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 5,
            'project_section' => 32,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 6,
            'project_section' => 37,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 6,
            'project_section' => 38,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 6,
            'project_section' => 39,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 7,
            'project_section' => 44,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 7,
            'project_section' => 45,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 7,
            'project_section' => 46,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 8,
            'project_section' => 51,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 8,
            'project_section' => 52,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 8,
            'project_section' => 53,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 9,
            'project_section' => 58,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 9,
            'project_section' => 59,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 9,
            'project_section' => 60,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 10,
            'project_section' => 65,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 10,
            'project_section' => 66,
            'project_deadline' => Carbon::now()->addYear(),
        ]);

        DB::table('jobs')->insert([
            'employers_id' => 1,
            'status' => 'open',
            'address' => 'XXX',
            'project_name' => 'Mukbanger',
            'project_description' => 'Makan makan',
            'project_type' => 'WFO',
            'salary' => 500000,
            'project_field' => 10,
            'project_section' => 67,
            'project_deadline' => Carbon::now()->addYear(),
        ]);
    }
}
