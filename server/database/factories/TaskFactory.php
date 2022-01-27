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
            'execution_interval' => $this->faker->randomDigit(),
            'is_enable' => $this->faker->boolean,
            'keyword' => $this->faker->sentence,
            'start_time_period' => $this->faker->time('H:i:s'),
            'end_time_period' => $this->faker->time('H:i:s'),
            'max_execution' => $this->faker->numberBetween(0, 10),
            'range_min_sleep_time' => $this->faker->numberBetween(5, 10),
            'range_max_sleep_time' => $this->faker->numberBetween(11, 20),
        ];
    }
}
