<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class KbCategory extends Model {
    protected $fillable = ['name','slug','description','sort'];
    public function articles() { return $this->hasMany(KbArticle::class, 'category_id'); }
}
