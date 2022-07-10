<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

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
        $statuses = collect([Lead::STATUS_PENDING, Lead::STATUS_APPLIED, Lead::STATUS_DECLINED]);

        return [
            'user_id' => User::factory(),
            'header' => fake()->realText(20),
            'description' => fake()->realText('512'),
            'desired_date' => fake()->dateTimeBetween('-1 year'),
            'status' => $statuses->random(),
        ];
    }
}
