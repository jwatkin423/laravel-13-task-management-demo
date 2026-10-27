<?php

namespace Database\Factories;

use App\Models\task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<task>
 */
class taskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (task $task) {
            $task->update(['priority' => $task->task_id]);
        });
    }
}
