<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Agent extends Model {
    protected $fillable = ['user_id','code','level','commission_rate','total_earned','withdrawable','is_active'];
    protected $casts = ['commission_rate'=>'decimal:2','total_earned'=>'decimal:2','withdrawable'=>'decimal:2','is_active'=>'boolean'];
    public function user() { return $this->belongsTo(User::class); }
    public function commissions() { return $this->hasMany(Commission::class); }
    public function withdrawals() { return $this->hasMany(Withdrawal::class); }
}
