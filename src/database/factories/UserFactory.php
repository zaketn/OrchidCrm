<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->firstNameMale(),
            'last_name' => fake()->lastName('male'),
            'middle_name' => fake()->middleNameMale(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'admin',
                'last_name' => 'admin',
                'middle_name' => 'admin',
                'email' => 'admin@admin.com',
                'permissions' => '{"platform.systems.roles":true,"platform.systems.users":true,"platform.systems.attachment":true,"platform.index":true}' // TODO fix screening quotes
            ];
        });
    }
}
