@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">⚙️ 系统设置</h1>

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf

    @forelse($settings as $group => $items)
    <div class="anime-card p-6 mb-6">
        <h2 class="text-lg font-bold mb-4" style="color:#FF9EC4">
            @if($group === 'site') 🌸 站点设置
            @elseif($group === 'mail') 📧 邮件设置
            @elseif($group === 'payment') 💴 支付设置
            @elseif($group === 'sms') 📱 短信设置
            @else 🔧 {{ $group }}
            @endif
        </h2>
        <div class="space-y-4">
            @foreach($items as $setting)
            <div>
                <label class="block text-sm text-gray-500 mb-1">{{ $setting->title ?? $setting->key }}</label>
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
    <div class="flex justify-end">
        <button type="submit" class="anime-btn">💾 保存设置</button>
    </div>
    @endif
</form>
@endsection
