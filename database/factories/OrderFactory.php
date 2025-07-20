<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'status' => OrderStatus::Initiated->value,
            'total' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}
