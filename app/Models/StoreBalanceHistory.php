<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreBalanceHistory extends Model
{
    use UUID;

    protected $fillable = ['store_balance_id', 'type', 'amount', 'remarks', 'reference_id', 'reference_type'];

    public function storeBalance(): BelongsTo
    {
        return $this->belongsTo(StoreBalance::class);
    }

    public function storeBalanceHistories()
    {
        return $this->hasMany(StoreBalanceHistory::class);
    }
}
