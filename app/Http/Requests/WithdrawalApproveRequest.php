<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawalApproveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'proof' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ];
    }

    public function attributes(): array
    {
        return [
            'proof' => 'Bukti transfer',
        ];
    }
}
