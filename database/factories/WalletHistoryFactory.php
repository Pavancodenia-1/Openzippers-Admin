<?php

namespace Database\Factories;

use App\Models\WalletHistory;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WalletHistory>
 */
class WalletHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? null,
            'admin_id' => Admin::inRandomOrder()->first()->id ?? null,
            'wallet_id' => Str::uuid(),
            'amount' => $this->faker->randomFloat(2, 1, 1000),
            'balance_before' => $this->faker->randomFloat(2, 1, 1000),

        ];
    }
}
