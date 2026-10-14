<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable {
    use HasFactory, Notifiable;
    protected $fillable = ['name','email','password','balance','points','total_spent','member_level_id','is_admin'];
    protected $hidden = ['password','remember_token'];
    protected function casts(): array {
        return [
            'email_verified_at'=>'datetime','password'=>'hashed',
            'balance'=>'decimal:2','is_admin'=>'boolean',
            'points'=>'integer','total_spent'=>'integer',
        ];
    }
    public function services() { return $this->hasMany(Service::class); }
    public function orders() { return $this->hasMany(Order::class); }
    public function recharges() { return $this->hasMany(Recharge::class); }
    public function tickets() { return $this->hasMany(Ticket::class); }
    public function agent() { return $this->hasOne(Agent::class); }
    public function memberLevel() { return $this->belongsTo(MemberLevel::class); }
    public function coupons() { return $this->belongsToMany(Coupon::class)->withPivot('order_id','used_at'); }
}
