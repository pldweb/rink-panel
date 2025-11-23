<?php

namespace Database\Factories;

use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreBalanceHistoryFactory extends Factory
{
    protected $model = StoreBalanceHistory::class;

    public function definition(): array
    {
        return [
            'store_balance_id' => StoreBalance::factory(),
            'type' => 'initial',
            'reference_id' => null,
            'reference_type' => null,
            'amount' => $this->faker->randomFloat(2, 0, 1000000),
            'remarks' => 'Pembuatan toko baru',
        ];
    }
}
