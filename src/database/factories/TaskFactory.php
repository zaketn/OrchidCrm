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
        $developersRole = Role::where('slug', 'dev')->first();
        $project = Project::has('contract')->inRandomOrder()->first();

        return [
            'user_id' => $developersRole->getUsers()->random()->id,
            'project_id' => $project->id,
            'header' => fake()->realText(30),
            'description' => fake()->realText('512'),
            'hours' => fake()->randomDigitNotZero(),
            'finished' => fake()->boolean(),
            'start_date' => fake()->dateTime(),
            'end_date' => fake()->dateTime(),

            //TODO fix end_date min then start_date
        ];
    }
}
