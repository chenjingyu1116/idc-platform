<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ApiToken extends Model {
    protected $fillable = ['user_id','name','token','scopes','last_used_at','expires_at'];
    protected $casts = ['scopes'=>'array','last_used_at'=>'datetime','expires_at'=>'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public static function generate($user, $name = 'API Token') {
        return static::create([
            'user_id' => $user->id,
            'name' => $name,
            'token' => bin2hex(random_bytes(32)),
            'scopes' => ['read','write'],
        ]);
    }
}
