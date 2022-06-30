<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $company = Company::inRandomOrder()->first();

        return [
            'company_id' => $company->id,
            'name' => fake()->firstNameMale(),
            'last_name' => fake()->lastName('male'),
            'middle_name' => fake()->middleNameMale(),
            'phone' => fake()->unique()->phoneNumber(),
        ];
    }
}
