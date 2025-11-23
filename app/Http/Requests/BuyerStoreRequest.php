<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyerStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'profile_picture' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'phone_number' => 'required|string|digits_between:8,14',
        ];
    }

    public function attributes(): array
    {
        return [
            'user_id' => 'User',
            'profile_picture' => 'Avatar',
            'phone_number' => 'Nomor HP',
        ];
    }
}
