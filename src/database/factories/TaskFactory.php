<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Role;
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
            'hours' => fake()->numberBetween(1, 100),
        ];
    }

    /**
     * State with start_date, end_date fields
     *
     * @return TaskFactory
     */
    public function finished()
    {
        return $this->state(function (array $attributes) {
           $start_date = fake()->dateTimeBetween('-1 year');
            return [
                'start_date' => $start_date,
                'end_date' => fake()->dateTimeBetween($start_date, '+1 week')
            ];
        });
    }
}
