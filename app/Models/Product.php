<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model {
    protected $fillable = ['name','slug','description','price','billing_cycle','config','stock','is_active'];
    protected $casts = ['config'=>'array','is_active'=>'boolean','price'=>'decimal:2'];
}
