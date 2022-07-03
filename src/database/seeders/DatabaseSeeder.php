<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call([
            CompanySeeder::class,
            RoleSeeder::class,
            LeadSeeder::class,
            ContractSeeder::class,
            ProjectSeeder::class,
            TaskSeeder::class,
            // MeetupSeeder::class,
            // TODO make meetup generation for each user with customer role
        ]);
    }
}
