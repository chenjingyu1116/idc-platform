<?php
namespace App\Services\Setting;

use App\Models\Setting;

class SettingService
{
    public const DEFAULTS = [
        'site_name' => ['樱花云', 'general', 'string', '站点名称'],
        'site_url' => ['http://localhost:8081', 'general', 'string', '站点地址'],
        'site_description' => ['二次元专属云平台', 'general', 'string', '站点描述'],
        'site_keywords' => ['樱花云,IDC,VPS,二次元', 'general', 'string', 'SEO 关键词'],
        'site_logo' => ['🌸', 'general', 'string', '站点 Logo（emoji 或 URL）'],
        'contact_email' => ['support@sakura.local', 'general', 'string', '联系邮箱'],
        'contact_qq' => ['', 'general', 'string', '客服 QQ'],
        'contact_wechat' => ['', 'general', 'string', '客服微信'],
        'footer_text' => ['樱花云 © 2026 · 二次元专属云平台', 'general', 'string', '页脚文字'],
        'currency' => ['CNY', 'general', 'string', '货币单位'],
        'default_locale' => ['zh_CN', 'general', 'string', '默认语言'],
        'enable_register' => ['1', 'general', 'string', '开放注册（1/0）'],
        'enable_agent' => ['1', 'general', 'string', '开启代理系统（1/0）'],
        'commission_level1' => ['0.05', 'agent', 'string', '一级返佣比例'],
        'commission_level2' => ['0.015', 'agent', 'string', '二级返佣比例'],
        'withdrawal_min' => ['10', 'agent', 'string', '最低提现金额'],
        'withdrawal_fee' => ['0', 'agent', 'string', '提现手续费比例'],
    ];

    public static function init(): void
    {
        foreach (self::DEFAULTS as $key => $meta) {
            Setting::firstOrCreate(
                ['key' => $key],
                ['value' => $meta[0], 'group_name' => $meta[1], 'type' => $meta[2], 'label' => $meta[3]]
            );
        }
        Setting::forget();
    }

    public static function all(): array
    {
        return Setting::pluck('value', 'key')->toArray();
    }
}
