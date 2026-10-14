<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Provider extends Model {
    protected $fillable = ['name','driver','api_url','credentials_encrypted','config','is_active'];
    protected $casts = ['credentials_encrypted'=>'encrypted:array','config'=>'array','is_active'=>'boolean'];
}
