<?php

namespace Database\Seeders;

use App\Models\Freelancer;
use App\Models\Users;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FieldSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(FreelancerSeeder::class);
        $this->call(EmployerSeeder::class);
        $this->call(JobSeeder::class);
        $this->call(StudySeeder::class);
        $this->call(ListMatchSeeder::class);
    }
}
