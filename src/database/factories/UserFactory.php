<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Orchid\Support\Facades\Dashboard;

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
            'company_id' => Company::factory(),
            'name' => fake()->firstNameMale(),
            'last_name' => fake()->lastName('male'),
            'middle_name' => fake()->middleNameMale(),
            'phone' => fake()->unique()->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Define the model's admin state
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
                'permissions' => Dashboard::getAllowAllPermission()
            ];
        });
    }
}
