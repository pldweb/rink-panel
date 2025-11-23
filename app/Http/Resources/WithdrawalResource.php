<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawalResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'store_balance' => new StoreBalanceResource($this->storeBalance),
            'amount' => (float) (string) $this->amount,
            'bank_account_name' => $this->bank_account_name,
            'bank_account_number' => $this->bank_acount_number,
            'bank_name' => $this->bank_name,
            'status' => $this->status
        ];
    }
}
