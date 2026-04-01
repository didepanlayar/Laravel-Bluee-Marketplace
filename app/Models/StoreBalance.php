<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class StoreBalance extends Model
{
    use UUID;

    protected $fillable = [
        'store_id',
        'balance'
    ];

    protected $casts = [
        'balance' => 'decimal:2'
    ];

    // Scope StoreBalance Search
    public function scopeSearch($query, $search)
    {
        return $query->whereHas('store', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });
    }

    // Relationship: one store owned by one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function storeBalanceHistories()
    {
        return $this->hasMany(StoreBalanceHistory::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }
}
