<?php

namespace Database\Seeders;

use App\Models\Meetup;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()
            ->has(User::factory(1))
            ->create(['name' => 'Директор', 'slug' => 'ceo']);

        Role::factory()
            ->has(User::factory(1)->admin())
            ->create(['name' => 'IT-Директор', 'slug' => 'cio']);

        Role::factory()
            ->has(User::factory(3))
            ->create(['name' => 'Менеджер', 'slug' => 'manager']);

        Role::factory()
            ->has(User::factory(5))
            ->create(['name' => 'Агент', 'slug' => 'agent']);

        Role::factory()
            ->has(User::factory(1))
            ->create(['name' => 'Бухгалтер', 'slug' => 'accountant']);

        Role::factory()
            ->has(User::factory(5))
            ->create(['name' => 'Старший разработчик', 'slug' => 'hl_dev']);

        Role::factory()
            ->has(User::factory(10))
            ->create(['name' => 'Разработчик', 'slug' => 'dev']);

        Role::factory()
            ->has(User::factory(20)->customer())
            ->create(['name' => 'Заказчик', 'slug' => 'customer']);
    }
}
