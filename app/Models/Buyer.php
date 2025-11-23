<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'phone_number',
    ];

    public function scopeSearch($query, $search)
    {
        $query = $query->whereHas('store', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });

        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


}
