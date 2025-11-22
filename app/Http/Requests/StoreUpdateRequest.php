<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'logo' => 'image|nullable|mimes:jpg,jpeg,png|max:2048',
            'about' => 'string|required',
            'phone' => 'string|required',
            'address_id' => 'required',
            'city' => 'string|required',
            'address' => 'string|required',
            'postal_code' => 'string|required',
        ];
    }
    public function attributes(): array
    {
        return [
            'name' => 'Nama Toko',
            'logo' => 'Logo Toko',
            'about' => 'Deskripsi Toko',
            'phone' => 'No. Telepon',
            'address_id' => 'Alamat Toko',
            'city' => 'Kota',
            'address' => 'Alamat',
            'postal_code' => 'Kode Pos',
        ];
    }
}
