<?php

namespace Database\Factories;

use App\Models\project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<project>
 */
class projectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_name' => $this->faker->sentence(1),
            'project_description' => $this->faker->sentence(),
        ];
    }
}
