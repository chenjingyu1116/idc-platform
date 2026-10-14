<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MemberLevel extends Model {
    protected $fillable = ['name','min_spent','discount','points_multiplier','color'];
    protected $casts = ['discount'=>'decimal:2'];
}
