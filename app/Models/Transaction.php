<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Transaction extends Model {
    protected $fillable = ['trade_no','out_trade_no','user_id','amount','type','ref_id','gateway','gateway_trade_no','status','gateway_response','paid_at'];
    protected $casts = ['amount'=>'decimal:2','gateway_response'=>'array','paid_at'=>'datetime'];
    public function user() { return $this->belongsTo(User::class); }
}
