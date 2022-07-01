<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $lead = Lead::has('customer')->inRandomOrder()->first();

        return [
            'lead_id' => $lead->id,
            'file_name' => fake()->unique()->md5().'.pdf'
        ];
    }
}
