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
        Role::factory()
            ->has(User::factory()->count(1))
            ->create(['name' => 'Директор', 'slug' => 'ceo']);

        Role::factory()
            ->has(User::factory()->admin()->count(1))
            ->create(['name' => 'IT-Директор', 'slug' => 'cio']);

        Role::factory()
            ->has(User::factory()->count(3))
            ->create(['name' => 'Менеджер', 'slug' => 'manager']);

        Role::factory()
            ->has(User::factory()->count(5))
            ->create(['name' => 'Агент', 'slug' => 'agent']);

        Role::factory()
            ->has(User::factory()->count(1))
            ->create(['name' => 'Бухгалтер', 'slug' => 'accountant']);

        Role::factory()
            ->has(User::factory()->count(5))
            ->create(['name' => 'Старший разработчик', 'slug' => 'hl_dev']);

        Role::factory()
            ->has(User::factory()->count(10))
            ->create(['name' => 'Разработчик', 'slug' => 'dev']);

        $this->call([
            CompanySeeder::class,
            CustomerSeeder::class,
            LeadSeeder::class,
            ContractSeeder::class,
            ProjectSeeder::class,
            TaskSeeder::class,
            MeetupSeeder::class,
        ]);
    }
}
