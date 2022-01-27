<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->randomNumber(9),
            'name' => $this->faker->name,
            'screen_name' => $this->faker->name,
            'avatar_path' => $this->faker->url,
            'access_token' => $this->faker->uuid,
            'access_token_secret' => $this->faker->uuid,
            'api_key' => $this->faker->uuid,
            'user_id' => User::factory()
        ];
    }
}
