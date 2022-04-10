<?php

namespace Database\Factories;

use App\Enums\TaskType;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::Factory(),
            'name' => $this->faker->name,
            'type' => TaskType::getRandomValue(),
            'execution_interval' => $this->faker->numberBetween(1, 200) * 5,
            'is_enable' => $this->faker->boolean,
            'keyword' => $this->faker->sentence,
            'start_time_period' => '10:00',
            'end_time_period' => '19:00',
            'max_execution' => $this->faker->numberBetween(0, 10),
            'range_min_sleep_time' => $this->faker->numberBetween(5, 10),
            'range_max_sleep_time' => $this->faker->numberBetween(11, 20),
        ];
    }
}
