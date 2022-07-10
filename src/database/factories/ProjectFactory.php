<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Role;
use App\Models\User;
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
        return [
            'user_id' => User::factory(),
            'contract_id' => Contract::factory(),
            'company_id' => Company::factory(),
            'name' => fake()->unique()->lexify('Project ??????'),
            'repo_link' => fake()->unique()->url()
        ];
    }
}
