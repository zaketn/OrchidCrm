<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $hlDevelopersRole = Role::where('slug', 'hl_dev')->first();
        $contract = Contract::has('lead')->inRandomOrder()->first();

        return [
            'user_id' => $hlDevelopersRole->getUsers()->random()->id,
            'contract_id' => $contract->id,
            'repo_link' => fake()->unique()->url()
        ];
    }
}
