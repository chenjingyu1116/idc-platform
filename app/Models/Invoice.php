<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Invoice extends Model {
    protected $fillable = ['invoice_no','user_id','order_id','subtotal','tax','total','status','title','due_date','paid_at'];
    protected $casts = ['subtotal'=>'decimal:2','tax'=>'decimal:2','total'=>'decimal:2','due_date'=>'date','paid_at'=>'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function order() { return $this->belongsTo(Order::class); }
}
