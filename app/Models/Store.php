<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use UUID;

    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'about',
        'phone',
        'address_id',
        'city',
        'address',
        'postal_code',
        'is_verified'
    ];

    // Relationship one store owned by one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Store can have one store balance relationship
    public function storeBalance()
    {
        return $this->hasOne(StoreBalance::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
