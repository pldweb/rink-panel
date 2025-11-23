<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreBalanceHistoryResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
          'store_balance' => new StoreBalanceResource($this->storeBalance),
          'type' => $this->type,
          'reference_Id' => $this->reference_id,
          'reference_type' => $this->reference_type,
            'amount' => (float) (string) $this->amount,
            'remarks' => $this->remarks
        ];
    }
}
