<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class KbArticle extends Model {
    protected $fillable = ['category_id','title','slug','content','views','is_published'];
    protected $casts = ['is_published'=>'boolean'];
    public function category() { return $this->belongsTo(KbCategory::class, 'category_id'); }
}
