<?php

namespace Database\Factories;

use App\Models\Manager;
use Illuminate\Database\Eloquent\Factories\Factory;

class FundFactory extends Factory
{
    public function definition(): array
    {
        return [
            'manager_id' => Manager::factory()->create()->getKey(),
            'name'       => fake()->company(),
            'start_year' => intval(fake()->year()),
            'aliases'    => [
                fake()->currencyCode(),
                fake()->currencyCode(),
                fake()->currencyCode(),
            ],
        ];
    }
}
