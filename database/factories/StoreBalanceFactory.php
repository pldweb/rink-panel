<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\StoreBalance;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreBalanceFactory extends Factory
{
    protected $model = StoreBalance::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'store_id' => Store::factory(),
            'balance' => $this->faker->randomFloat(2, 0, 1000000)
        ];
    }
}
