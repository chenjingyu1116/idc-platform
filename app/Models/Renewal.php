<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Renewal extends Model {
    protected $fillable = ['service_id','user_id','amount','cycle','started_at','expires_at','status'];
    protected $casts = ['amount'=>'decimal:2','started_at'=>'datetime','expires_at'=>'datetime'];
    public function service() { return $this->belongsTo(Service::class); }
    public function user() { return $this->belongsTo(User::class); }
}
