<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    protected $fillable = ['user_id', 'coupon_id', 'status', 'used_at', 'order_id'];
    protected $casts = ['used_at' => 'datetime'];

    public function user()   { return $this->belongsTo(User::class); }
    public function coupon() { return $this->belongsTo(Coupon::class); }
}
