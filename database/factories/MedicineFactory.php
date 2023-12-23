<?php

namespace Database\Factories;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'scientific_name' => fake()->word(),
            'commercial_name' => fake()->word(),
            'category_id' => fake()->numberBetween(1,4),
            'manufacture_company' => fake()->company(),
            'quantity_available' =>fake()->numberBetween(20,500),
            'expiration_date'=>fake()->dateTimeBetween('now','+7 years')->format('Y-m-d h:i:s'),
            'price'=>fake()->numberBetween(50,5000),
            'warehouse_id'=>fake()->numberBetween(1,4),
        ];

    }
}
