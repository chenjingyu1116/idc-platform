@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">⚙️ 系统设置</h1>

@php
$groupTitles = [
    'general' => '🌸 通用设置',
    'agent'   => '👥 代理设置',
    'site'    => '🌐 站点设置',
    'mail'    => '📧 邮件设置',
    'sms'     => '📱 短信设置',
    'payment' => '💴 支付设置',
    'system'  => '🔧 系统设置',
];

$keyTitles = [
    'site_name'         => '站点名称',
    'site_url'          => '站点地址',
    'site_description'  => '站点描述（SEO）',
    'site_keywords'     => '站点关键词（SEO）',
    'site_logo'         => '站点 Logo（emoji 或图片 URL）',
    'site_slogan'       => '站点标语',
    'footer_text'       => '页脚文字',
    'contact_email'     => '联系邮箱',
    'contact_qq'        => '客服 QQ',
    'contact_wechat'    => '客服微信',
    'currency'          => '默认货币',
    'default_locale'    => '默认语言',
    'enable_register'   => '开放注册（1 开启 / 0 关闭）',
    'enable_agent'      => '开启代理功能（1 开启 / 0 关闭）',
    'icp'               => 'ICP 备案号',
    'icp_link'          => 'ICP 备案链接',
    'commission_level1' => '一级代理返佣比例（0.05 = 5%）',
    'commission_level2' => '二级代理返佣比例',
    'withdrawal_min'    => '最低提现金额',
    'withdrawal_fee'    => '提现手续费',
];

$tips = [
    'site_name'         => '显示在导航栏和浏览器标题',
    'site_url'          => '填写完整 URL，含 http://',
    'site_description'  => '用于搜索引擎 SEO',
    'site_keywords'     => '用英文逗号分隔',
    'site_logo'         => '推荐使用 emoji，如 🌸 或 🌟',
    'footer_text'       => '显示在页面底部',
    'currency'          => '如 CNY / USD / HKD',
    'default_locale'    => '如 zh_CN / en',
    'enable_register'   => '关闭后新用户无法注册',
    'enable_agent'      => '关闭后代理入口隐藏',
    'icp'               => '没有备案可留空，或填「备案中」',
    'icp_link'          => '默认跳转工信部备案查询',
    'commission_level1' => '一级代理从订单中获得的比例',
    'commission_level2' => '二级代理从订单中获得的比例',
    'withdrawal_min'    => '低于此金额无法申请提现',
    'withdrawal_fee'    => '提现金额 × 此比例 = 手续费',
];
@endphp

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf

    @forelse($settings as $group => $items)
    <div class="anime-card p-6 mb-6">
        <h2 class="text-lg font-bold mb-4" style="color:#FF9EC4">
            {{ $groupTitles[$group] ?? $group }}
        </h2>
        <div class="space-y-4">
            @foreach($items as $setting)
            @php
                $label = $keyTitles[$setting->key] ?? ($setting->title ?: $setting->key);
                $tip = $tips[$setting->key] ?? null;
            @endphp
            <div>
                <label class="block text-sm font-semibold mb-1" style="color:#4A4A6A">
                    {{ $label }}
                    <span class="text-xs text-gray-400 ml-2 font-mono">({{ $setting->key }})</span>
                </label>
                @if($tip)
                <div class="text-xs text-gray-400 mb-2">💡 {{ $tip }}</div>
                @endif
                @if(($setting->type ?? 'text') === 'textarea')
                    <textarea name="{{ $setting->key }}" rows="4" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">{{ $setting->value }}</textarea>
                @elseif(($setting->type ?? 'text') === 'switch')
                    <select name="{{ $setting->key }}" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
                        <option value="1" @if($setting->value == '1') selected @endif>开启</option>
                        <option value="0" @if($setting->value == '0') selected @endif>关闭</option>
                    </select>
                @else
                    <input type="text" name="{{ $setting->key }}" value="{{ $setting->value }}" class="w-full px-4 py-2 rounded-2xl border-2" style="border-color:#FFD1E8;background:rgba(255,245,250,.5);outline:none">
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="anime-card p-8 text-center text-gray-400">暂无设置项</div>
    @endforelse

    @if(count($settings) > 0)
    <div class="flex justify-end sticky bottom-4">
        <button type="submit" class="anime-btn shadow-lg">💾 保存设置</button>
    </div>
    @endif
</form>
@endsection
