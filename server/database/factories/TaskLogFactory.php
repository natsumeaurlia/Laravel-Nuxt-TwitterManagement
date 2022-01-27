<?php

namespace Database\Factories;

use App\Enums\TaskType;
use App\Models\Account;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'result' => $this->faker->boolean,
            'type' => TaskType::getRandomValue(),
            'execution_interval' => $this->faker->randomDigit(),
            'action_count' => $this->faker->randomDigit(),
            'success_count' => $this->faker->randomDigit(),
            'failed_count' => $this->faker->randomDigit(),
            'account_id' => Account::factory(),
            'task_id' => Task::factory(),
        ];
    }
}
