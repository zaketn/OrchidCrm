<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Lead;
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
        return [
            'lead_id' => Lead::factory(),
            'address' => fake()->streetAddress(),
            'place' => fake()->streetSuffix(),
            'date_time' => fake()->dateTimeBetween('-1 year', '+1 year')
        ];
    }
}
