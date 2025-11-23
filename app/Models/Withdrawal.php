<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'store_balance_id',
        'bank_account_name',
        'bank_account_number',
        'bank_name',
        'status',
        'proof'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('storeBalance.store', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function storeBalance()
    {
        return $this->belongsTo(StoreBalance::class);
    }
}
