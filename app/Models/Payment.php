<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model {
    protected $fillable = ['trade_no','user_id','payable_type','payable_id','amount','gateway','gateway_trade_no','status','payload','paid_at'];
    protected $casts = ['amount'=>'decimal:2','payload'=>'array','paid_at'=>'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function payable() { return $this->morphTo(); }
}
