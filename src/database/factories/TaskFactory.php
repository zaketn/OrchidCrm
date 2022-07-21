<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'header' => fake()->realText(20),
            'description' => fake()->realText('512'),
            'deadline' => fake()->dateTimeBetween('-1 year', '+1 year'),
        ];
    }
}
