<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductReviewRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'transaction_id' => 'required|string|exists:transactions,id',
            'product_id' => 'required|string|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string'
        ];
    }

    public function attributes(): array
    {
        return [
            'transaction_id' => 'Transaksi',
            'product_id' => 'Produk',
            'rating' => 'Rating',
            'review' => 'Review'
        ];
    }
}
