<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Commission extends Model {
    protected $fillable = ['agent_id','order_id','amount','rate','status','settled_at'];
    protected $casts = ['amount'=>'decimal:2','rate'=>'decimal:2','settled_at'=>'datetime'];
    public function agent() { return $this->belongsTo(Agent::class); }
    public function order() { return $this->belongsTo(Order::class); }
}
