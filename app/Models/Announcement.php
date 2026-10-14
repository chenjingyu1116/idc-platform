<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Announcement extends Model {
    protected $fillable = ['title','content','type','is_pinned','is_active','published_at'];
    protected $casts = ['is_pinned'=>'boolean','is_active'=>'boolean','published_at'=>'datetime'];
    public function scopeActive($q) { return $q->where('is_active',true)->orderByDesc('is_pinned')->orderByDesc('published_at'); }
}
