<?php

namespace App\Repositories;

use App\Interfaces\TransactionDetailRepositoryInterface;
use App\Models\Product;
use App\Models\TransactionDetail;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionDetailRepository implements TransactionDetailRepositoryInterface
{
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $transaction = new TransactionDetail;
            $transaction->transaction_id = $data['transaction_id'];
            $transaction->product_id = $data['product_id'];
            $transaction->qty = $data['qty'];

            $product = Product::find($data['product_id']);
            $transaction->subtotal = $product->price * $data['qty'];
            $transaction->save();

            DB::commit();

            return $transaction;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
