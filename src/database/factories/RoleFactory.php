<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // TODO add permissions

        return [
            'slug' => fake()->unique()->numerify('role ###'),
            'name' => fake()->unique()->numerify('role ###'),
            'permissions' => null
        ];
    }
}
