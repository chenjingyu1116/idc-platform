<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Service extends Model {
    use SoftDeletes;
    protected $fillable = ['user_id','order_id','product_id','service_type','provider_type','provider_id','upstream_product_id','upstream_service_id','ip_address','username','password_encrypted','resource_config','status','activated_at','expires_at'];
    protected $casts = ['resource_config'=>'array','password_encrypted'=>'encrypted','activated_at'=>'datetime','expires_at'=>'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function order() { return $this->belongsTo(Order::class); }
    public function product() { return $this->belongsTo(Product::class); }
    public function provider() { return $this->belongsTo(Provider::class); }
}
