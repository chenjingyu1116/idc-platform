<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Coupon extends Model {
    protected $fillable = ['code','name','type','value','min_amount','total','used','expires_at','is_active'];
    protected $casts = ['value'=>'decimal:2','min_amount'=>'decimal:2','expires_at'=>'datetime','is_active'=>'boolean'];
    public function users() { return $this->belongsToMany(User::class)->withPivot('order_id','used_at'); }
}
