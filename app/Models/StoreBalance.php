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

    // Relationship: one store owned by one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
