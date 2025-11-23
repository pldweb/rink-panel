<?php

namespace Database\Factories;

use App\Models\StoreBalance;
use App\Models\Withdrawal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Withdrawal>
 */
class WithdrawalFactory extends Factory
{

    protected $model = Withdrawal::class;

    public function definition(): array
    {
        return [
            'store_balance_id' => StoreBalance::factory(),
            'amount' => function (array $attributes) {
                $storeBalance = StoreBalance::find($attributes['store_balance_id']);
                return $this->faker->randomFloat(2, 0, $storeBalance->balance);
            },
            'bank_account_name' => $this->faker->name,
            'bank_account_number' => $this->faker->numerify('###########'),
            'bank_name' => $this->faker->randomElement(['BCA', 'Mandiri', 'BRI', 'BNI']),
            'status' => 'pending'
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Withdrawal $withdrawal) {

            // Histori permintaan penarikan (pending)
            $withdrawal->storeBalance->storeBalanceHistories()->create([
                'type' => 'withdrawal',
                'reference_id' => $withdrawal->id,
                'reference_type' => Withdrawal::class,
                'amount' => $withdrawal->amount,
                'remarks' => "Permintaan penarikan dana ke {$withdrawal->bank_name} - {$withdrawal->bank_account_number}"
            ]);

            // penarikan dana
            $withdrawal->storeBalance->storeBalanceHistories()->create([
                'type' => 'withdrawal',
                'reference_id' => $withdrawal->id,
                'reference_type' => Withdrawal::class,
                'amount' => $withdrawal->amount,
                'remarks' => "Permintaan penarikan dana ke {$withdrawal->bank_name} - {$withdrawal->bank_account_number} telah di proses"
            ]);

            $withdrawal->update(['status' => 'approved']);

            $withdrawal->storeBalance->update([
                'balance' => $withdrawal->storeBalance->balance - $withdrawal->amount,
            ]);
        });
    }
}
