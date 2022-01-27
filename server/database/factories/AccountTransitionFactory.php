<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountTransitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'follower' => $this->faker->randomNumber(),
            'follow' => $this->faker->randomNumber(),
            'favourite' => $this->faker->randomNumber(),
            'tweet' => $this->faker->randomNumber(),
        ];
    }
}
