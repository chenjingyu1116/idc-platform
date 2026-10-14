<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProductMapping extends Model {
    protected $fillable = ['product_id','provider_id','upstream_product_id','upstream_config'];
    protected $casts = ['upstream_config'=>'array'];
    public function product() { return $this->belongsTo(Product::class); }
    public function provider() { return $this->belongsTo(Provider::class); }
}
