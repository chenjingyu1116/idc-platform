<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model {
    protected $fillable = ['order_no','user_id','product_id','quantity','total_amount','status','paid_at'];
    protected $casts = ['paid_at'=>'datetime','total_amount'=>'decimal:2'];
    public function user() { return $this->belongsTo(User::class); }
    public function product() { return $this->belongsTo(Product::class); }
    public function services() { return $this->hasMany(Service::class); }
}
