<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TableauFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'category' => $this->faker->randomElement(array_keys(\App\Models\Tableau::$categories)),
            'price' => $this->faker->randomFloat(2, 999, 5999),
            'image' => 'placeholder-' . $this->faker->numberBetween(1, 6) . '.jpg',
        ];
    }
}