<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word, // Menghasilkan nama kategori acak
            'is_publish' => $this->faker->boolean, // Menghasilkan nilai true/false secara acak
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
