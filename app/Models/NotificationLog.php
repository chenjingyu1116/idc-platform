<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class NotificationLog extends Model {
    protected $fillable = ['user_id','channel','event','title','content','status','error','sent_at'];
    protected $casts = ['sent_at'=>'datetime'];
    public function user() { return $this->belongsTo(User::class); }
}
