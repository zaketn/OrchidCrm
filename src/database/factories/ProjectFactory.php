<?php

namespace Database\Factories;

use App\Models\Project;
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
        $statuses = collect([
            Project::STATUS_STARTED,
            Project::STATUS_FINISHED,
            Project::STATUS_CANCELLED,
            Project::STATUS_STOPPED
        ]);

        return [
            'name' => fake()->unique()->lexify('Project ??????'),
            'status' => $statuses->random(),
            'repo_link' => fake()->unique()->url()
        ];
    }
}
