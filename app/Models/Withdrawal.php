<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Withdrawal extends Model {
    protected $fillable = ['agent_id','amount','account_type','account_no','status','remark'];
    protected $casts = ['amount'=>'decimal:2'];
    public function agent() { return $this->belongsTo(Agent::class); }
}
