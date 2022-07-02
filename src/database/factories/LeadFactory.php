<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $customer = User::where('company_id', '!=', 1)->has('company')->inRandomOrder()->first();

        $statuses = ['pending', 'applied', 'declined'];
        $selectedStatus = $statuses[rand(0, count($statuses) - 1)];
        $employeeMessage = $selectedStatus == 'declined' ? fake()->realText(32) : null;

        return [
            'user_id' => $customer->id,
            'header' => fake()->realText(20),
            'description' => fake()->realText('512'),
            'desired_date' => fake()->dateTime(),
            'status' => $selectedStatus,
            'employee_message' => $employeeMessage,
        ];
    }
}
