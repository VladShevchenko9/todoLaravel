<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'description' => fake()->paragraph(),
            'priority' => fake()->numberBetween(1, 5),
            'status' => fake()->boolean(),
        ];
    }
}
