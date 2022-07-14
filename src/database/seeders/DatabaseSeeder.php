<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Lead;
use App\Models\Meetup;
use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
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
        $localCompany = Company::factory()->local()->create();

        $ceoUser = User::factory()
            ->admin()
            ->for($localCompany)
            ->has(Role::factory()->ceo())
            ->create();

        $cioUser = User::factory()
            ->for($localCompany)
            ->has(Role::factory()->cio())
            ->create();

        $managerRole = Role::factory()->manager()->create();
        $agentRole = Role::factory()->agent()->create();
        $accountantRole = Role::factory()->accountant()->create();
        $hlDevRole = Role::factory()->hlDev()->create();
        $devRole = Role::factory()->dev()->create();
        $customerRole = Role::factory()->customer()->create();

        $managerUser = User::factory(3)->for($localCompany)->hasAttached($managerRole)->create();
        $agentUser = User::factory(3)->for($localCompany)->hasAttached($agentRole)->create();
        $accountantUser = User::factory(2)->for($localCompany)->hasAttached($accountantRole)->create();
        $hlDevUser = User::factory(5)->for($localCompany)->hasAttached($hlDevRole)->create();
        $devUser = User::factory(10)->for($localCompany)->hasAttached($devRole)->create();

        $employees = collect([$ceoUser, $cioUser, $managerUser, $agentUser, $accountantUser, $hlDevUser, $devUser]);

        $customersAmount = 10;

        for ($i = 0; $i < $customersAmount; $i++) {
            $company = Company::factory()->create();

            $customerUser = User::factory()
                ->for($company)
                ->hasAttached($customerRole)
                ->create();

            $lead = Lead::factory()->for($customerUser)->create();

            Meetup::factory()
                ->for($lead)
                ->hasAttached($customerUser)
                ->hasAttached($agentUser->random())
                ->create();

            $contract = Contract::factory()->for($company)->create();

            $project = Project::factory()
                ->for($customerUser)
                ->for($contract)
                ->create();

            Task::factory(5)
                ->for($project)
                ->hasAttached($employees->random())
                ->create();
        }
    }
}
