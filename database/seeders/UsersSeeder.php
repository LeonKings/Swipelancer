<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'employer@gmail.com',
            'password' => bcrypt('12345678'),
            'role_id' => 2,
            'email_verified_at' => Carbon::now(),
            'plan' => 'Free',
            'swipe_count' => null,
            'swipe_date' => null,
            'subscribe_until' => null,
        ]);

        DB::table('users')->insert([
            'email' => 'freelancer@gmail.com',
            'password' => bcrypt('12345678'),
            'role_id' => 1,
            'email_verified_at' => Carbon::now(),
            'plan' => 'Free',
            'swipe_count' => null,
            'swipe_date' => null,
            'subscribe_until' => null,
        ]);
    }
}
