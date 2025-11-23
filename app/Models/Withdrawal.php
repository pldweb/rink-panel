<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use UUID;

    protected $fillable = ['user_id',
        'amount',
        'status',
        'store_balance_id',
        'bank_account_name',
        'bank_account_number',
        'bank_name',
    ];

    public function storeBalance()
    {
        return $this->belongsTo(StoreBalance::class);
    }
}
