<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->toDateString(),
            'description' => fake()->text(),
            'file_path' => fake()->filePath(),
        ];
    }
}
