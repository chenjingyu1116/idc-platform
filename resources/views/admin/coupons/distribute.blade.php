@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto">
<h1 class="text-2xl font-bold mb-2">🎁 发放优惠券</h1>
<div class="text-sm text-gray-500 mb-6">
    <span class="font-mono" style="color:#FF9EC4">{{ $coupon->code }}</span> ·
    {{ $coupon->name }} ·
    {{ $coupon->type === 'fixed' ? '¥'.$coupon->value : $coupon->value.'%' }}
</div>

<form method="POST" action="{{ route('admin.coupons.doDistribute', $coupon) }}" class="space-y-6">
@csrf

{{-- 模式选择 --}}
<div class="anime-card rounded-2xl p-6">
<h2 class="font-bold mb-4" style="color:#FF9EC4">1. 选择发放方式</h2>
<div class="grid grid-cols-2 gap-4">
    <label class="cursor-pointer">
        <input type="radio" name="mode" value="manual" checked onchange="switchMode()" class="hidden peer">
        <div class="anime-card p-4 text-center peer-checked:border-pink-400 peer-checked:border-4" style="border-width:2px">
            <div class="text-3xl mb-2">👤</div>
            <div class="font-semibold">指定发放</div>
            <div class="text-xs text-gray-500 mt-1">手动选择特定用户</div>
        </div>
    </label>
    <label class="cursor-pointer">
        <input type="radio" name="mode" value="group" onchange="switchMode()" class="hidden peer">
        <div class="anime-card p-4 text-center peer-checked:border-pink-400 peer-checked:border-4" style="border-width:2px">
            <div class="text-3xl mb-2">👥</div>
            <div class="font-semibold">群体发放</div>
            <div class="text-xs text-gray-500 mt-1">按条件批量发送</div>
        </div>
    </label>
</div>
</div>

{{-- 指定发放：用户列表 --}}
<div id="manual-panel" class="anime-card rounded-2xl p-6">
<h2 class="font-bold mb-4" style="color:#FF9EC4">2. 选择用户</h2>
<div class="flex gap-2 mb-3">
    <button type="button" onclick="selectAll()" class="text-xs anime-btn-soft">全选</button>
    <button type="button" onclick="unselectAll()" class="text-xs anime-btn-soft">全不选</button>
</div>
<div class="max-h-96 overflow-y-auto border-2 rounded-xl p-3" style="border-color:#FFD1E8">
@foreach($users as $u)
<label class="flex items-center gap-3 py-2 hover:bg-pink-50/40 rounded px-2 cursor-pointer">
    <input type="checkbox" name="user_ids[]" value="{{ $u->id }}" class="user-checkbox">
    <span class="font-mono text-xs text-gray-400">#{{ $u->id }}</span>
    <span>{{ $u->name }}</span>
    <span class="text-xs text-gray-400">{{ $u->email }}</span>
    @if($u->is_admin)<span class="text-xs px-2 py-0.5 rounded-full" style="background:rgba(179,157,219,.2);color:#B39DDB">管理员</span>@endif
</label>
@endforeach
</div>
</div>

{{-- 群体发放：条件选择 --}}
<div id="group-panel" class="anime-card rounded-2xl p-6" style="display:none">
<h2 class="font-bold mb-4" style="color:#FF9EC4">2. 选择群体</h2>
<div class="space-y-3">
    @php
        $groups = [
            'all'         => ['全部用户', '所有已注册用户'],
            'no_admin'    => ['仅普通用户', '排除管理员'],
            'has_order'   => ['有订单用户', '下过单的用户'],
            'no_order'    => ['无订单用户', '从未下单的用户'],
            'has_balance' => ['有余额用户', '余额大于 0'],
            'new_7d'      => ['近 7 天注册', '最近 7 天内注册的用户'],
            'new_30d'     => ['近 30 天注册', '最近 30 天内注册的用户'],
        ];
    @endphp
    @foreach($groups as $key => $info)
    <label class="flex items-start gap-3 p-3 rounded-xl border-2 cursor-pointer hover:bg-pink-50/30" style="border-color:#FFD1E8">
        <input type="radio" name="group" value="{{ $key }}" class="mt-1">
        <div>
            <div class="font-semibold">{{ $info[0] }}</div>
            <div class="text-xs text-gray-500">{{ $info[1] }}</div>
        </div>
    </label>
    @endforeach
</div>
</div>

<div class="flex justify-end gap-3">
    <a href="{{ route('admin.coupons.index') }}" class="px-6 py-3 rounded-2xl border-2" style="border-color:#FFD1E8">取消</a>
    <button type="submit" class="anime-btn">🎁 立即发放</button>
</div>

</form>
</div>

<script>
function switchMode() {
    var mode = document.querySelector('input[name="mode"]:checked').value;
    document.getElementById('manual-panel').style.display = mode === 'manual' ? 'block' : 'none';
    document.getElementById('group-panel').style.display  = mode === 'group'  ? 'block' : 'none';
}
function selectAll()   { document.querySelectorAll('.user-checkbox').forEach(c => c.checked = true); }
function unselectAll() { document.querySelectorAll('.user-checkbox').forEach(c => c.checked = false); }
</script>
@endsection
