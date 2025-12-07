<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'tracking_number' => 'nullable|integer',
            'delivery_proof' => 'nullable|image|mimes:jpg,jpeg,png',
            'delivery_status' => 'required|in:processing,delivered,completed',
        ];
    }

    public function attributes(): array
    {
        return [
            'tracking_number' => 'Nomor Resi',
            'delivery_proof' => 'Bukti Pengiriman',
            'delivery_status' => 'Status Pengiriman',
        ];
    }

    public function prepareForValidation()
    {
        if (!$this->delivery_proof){
            $this->merge([
                'delivery_proof' => null
            ]);
        }
    }
}
