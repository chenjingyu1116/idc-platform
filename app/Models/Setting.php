<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key','value','group_name','type','label'];

    public static function get(string $key, $default = null)
    {
        $settings = Cache::rememberForever('settings_all', function () {
            return self::pluck('value', 'key')->toArray();
        });
        return $settings[$key] ?? $default;
    }

    public static function set(string $key, $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings_all');
    }

    public static function forget(): void
    {
        Cache::forget('settings_all');
    }
}
