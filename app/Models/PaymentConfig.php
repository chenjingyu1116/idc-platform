<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PaymentConfig extends Model {
    protected $fillable = ['name','driver','api_url','pid','key_secret','notify_url','return_url','extra','is_active','sort'];
    protected $casts = ['extra'=>'array','is_active'=>'boolean'];
}
