<?php

namespace App\Http\Resources;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'transaction' => new TransactionResource($this->transaction),
            'rating' => $this->rating,
            'review' => $this->review
        ];
    }
}
