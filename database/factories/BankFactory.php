<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bank>
 */
class BankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'bank_name' => $this->faker->company(),
            'account_number' => $this->faker->numberBetween(1000, 1000000),
            'account_name' => $this->faker->name(),
            'user_id' => User::Factory()
        ];
    }
}
