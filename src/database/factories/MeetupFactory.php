<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meetup>
 */
class MeetupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $agentRole = Role::where('slug', 'agent')->first();
        $customerWithLead = User::where('company_id', '!=', 1)->has('leads')->inRandomOrder()->first();

        return [
            'address' => fake()->streetAddress(),
            'place' => fake()->cityPrefix(),
            'date_time' => fake()->date(), //TODO fix date range
        ];
    }
}
