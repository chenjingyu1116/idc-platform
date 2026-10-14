<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Recharge extends Model {
    protected $fillable = ['user_id','amount','status','remark'];
    protected $casts = ['amount'=>'decimal:2'];
    public function user() { return $this->belongsTo(User::class); }
}
