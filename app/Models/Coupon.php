<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'name', 'type', 'value', 'min_amount',
        'total', 'used', 'expires_at', 'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active'  => 'boolean',
        'value'      => 'decimal:2',
        'min_amount' => 'decimal:2',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_coupons')
            ->withPivot(['status', 'used_at', 'order_id'])
            ->withTimestamps();
    }

    public function userCoupons()
    {
        return $this->hasMany(UserCoupon::class);
    }
}
