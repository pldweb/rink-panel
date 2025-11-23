<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawalStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'store_balance_id' => 'required|exists:store_balances,id',
            'amount' => 'required|integer|min:0',
            'bank_account_name' => 'required|string',
            'bank_account_number' => 'required|string',
            'bank_name' => 'required|string|in:bri,bca,mandiri,bni',
        ];
    }

    public function attributes()
    {
        return [
            'store_balance_id' => 'Dompet Toko',
            'amount' => 'Nominal',
            'bank_account_name' => 'Nama Pemilik Rekening',
            'bank_account_number' => 'No. Rekening',
            'bank_name' => 'Nama Bank',
        ];
    }
}
