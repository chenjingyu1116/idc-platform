@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">🎫 我的优惠券</h1>
<div class="grid md:grid-cols-3 gap-4">
@forelse(($coupons ?? []) as $c)
<div class="anime-card p-6">
<div class="text-3xl font-bold mb-2" style="color:#FF9EC4">
@if(($c->type ?? '') === 'fixed') ¥{{ $c->value }} @else {{ $c->value }}% @endif
</div>
<div class="font-semibold mb-1">{{ $c->name }}</div>
<div class="text-xs text-gray-500 font-mono">{{ $c->code }}</div>
</div>
@empty
<div class="col-span-3 anime-card p-8 text-center text-gray-400">暂无优惠券</div>
@endforelse
</div>
@endsection
